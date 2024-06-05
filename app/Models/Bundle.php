<?php

namespace App\Models;

use App\Models\Garment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'lay_no', 'lot_no', 'po_no', 'style_no', 'size', 'qty', 'barcode_from', 'barcode_to','bundle_no','current_section'
    ];

    public function garments()
    {
        return $this->hasMany(Garment::class);
    }

    public static function updateOrCreateWithGarments($attributes, $values)
    {
        $bundle = self::updateOrCreate($attributes, $values);
    
        if ($bundle && isset($values['qty'], $values['barcode_from'], $values['barcode_to'])) {
            $barcodeFrom = (int)$values['barcode_from'];
            $barcodeTo = (int)$values['barcode_to'];
    
            // Remove existing garments for the bundle
            Garment::where('bundle_id', $bundle->id)->delete();
    
            for ($i = $barcodeFrom; $i <= $barcodeTo; $i++) {
                Garment::create([
                    'bundle_id' => $bundle->id,
                    'barcode' => sprintf('%04d', $i), // Ensure the barcode is four digits
                    'current_section' => 'cutting',
                    'status' => 'in_progress'
                ]);
            }
        }
    
        return $bundle;
    }
    

    
   
}
