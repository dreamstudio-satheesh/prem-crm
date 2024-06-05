<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scan;
use App\Models\Tracking;
use App\Models\Garment;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ScanController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        if ($this->isBatch($data)) {
            return $this->storeBatch($data);
        } else {
            return $this->storeSingle($data);
        }
    }

    private function storeSingle(array $data)
    {
        try {
            // Validate the incoming request data
            $validatedData = $this->validateSingle($data);

            // Create the scan record
            Scan::create($validatedData);

            // Process tracking update
            $this->processTrackingUpdate([$validatedData]);

            return response()->json(['success' => true], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Failed to store scan: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    private function storeBatch(array $data)
    {
        try {
            $validData = [];
            foreach ($data as $record) {
                $validatedData = $this->validateSingle($record);
                $validData[] = $validatedData;
            }

            // Bulk insert the valid data into Scan table
            Scan::insert($validData);

            // Process tracking updates for each validated data
            $this->processTrackingUpdate($validData);

            return response()->json(['success' => true], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Failed to store scans: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    private function validateSingle(array $data)
    {
        return validator($data, [
            'scanner_id' => 'required|string',
            'barcode' => 'required|string',
            'timestamp' => 'required|date_format:Y-m-d H:i:s',
        ])->validate();
    }

    private function processTrackingUpdate(array $validatedDataBatch)
    {
        foreach ($validatedDataBatch as $validatedData) {
            // Map scanner ID to checkpoint ID
            $checkpointId = $this->getCheckpointFromScannerId($validatedData['scanner_id']);

            if ($checkpointId) {
                // Get garment details from barcode
                $garment = $this->getGarmentFromBarcode($validatedData['barcode']);

                if ($garment) {
                    // Check if a record with the same garment_id and checkpoint_id exists
                    $tracking = Tracking::where('garment_id', $garment->id)
                                        ->where('checkpoint_id', $checkpointId)
                                        ->first();

                    if ($tracking) {
                        // Update the existing record
                        $tracking->timestamp = $validatedData['timestamp'];
                        $tracking->save();
                        Log::info("Updated tracking for garment_id: {$garment->id}, checkpoint_id: {$checkpointId}");
                    } else {
                        // Insert a new record
                        Tracking::create([
                            'garment_id' => $garment->id,
                            'checkpoint_id' => $checkpointId,
                            'timestamp' => $validatedData['timestamp'],
                        ]);
                        Log::info("Inserted new tracking for garment_id: {$garment->id}, checkpoint_id: {$checkpointId}");
                    }
                } else {
                    Log::warning("Garment not found for barcode: {$validatedData['barcode']}");
                }
            } else {
                Log::warning("Invalid checkpoint ID for scanner_id: {$validatedData['scanner_id']}");
            }
        }
    }

    private function isBatch(array $data)
    {
        return is_array($data) && isset($data[0]) && is_array($data[0]);
    }

    public function getLastScan()
    {
        $lastScan = Scan::latest('timestamp')->first();

        if ($lastScan) {
            return response()->json($lastScan);
        } else {
            return response()->json(['message' => 'No records found'], 200);
        }
    }

    private function getCheckpointFromScannerId($scannerId)
    {
        $scannerToCheckpointMap = [
            'A' => 2,
            'b' => 3,  // Lowercase 'b' handled
            'C' => 4,
        ];

        return $scannerToCheckpointMap[$scannerId] ?? null;
    }

    private function getGarmentFromBarcode($barcode)
    {
        return Garment::where('barcode', $barcode)->first();
    }
}
