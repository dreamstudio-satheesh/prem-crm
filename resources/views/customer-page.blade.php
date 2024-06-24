@extends('layouts.admin')

@section('content')
        <!-- Start Page Header -->
        <div class="row mb-4">
            <div class="col-12 d-flex align-items-center">
                <a href="#" class="me-2">Back</a>
                <h4 class="mb-0">TallyPrime Gold</h4>
                <span class="ms-3">Serial Number 752335416</span>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Start Subscription and License Info -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-0">TSS Subscription: <span class="text-success">● Active</span></p>
                        <p>Expires on 30-Nov-2024 <a href="#" class="text-primary">RENEW</a></p>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-0">License Status: <span class="text-success">● Active</span></p>
                        <p>Permanent License<br>Gold India Unlimited(Users)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-0">TVU: <span class="text-primary">10</span></p>
                        <p>Session: 5<br>[10 Default TVU]</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Subscription and License Info -->

        <!-- Start Information Sections -->
        <div class="row">
            <!-- Site/Branch Information -->
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Site/Branch Information</h5>
                        <p>Admin E-mail ID: <span class="text-success">tally@preminfotech.in</span></p>
                        <p>Site ID: Primary</p>
                        <p>Site Name: Prem Infotech</p>
                        <p>Email-ID of Account/Site Admin: <span class="text-success">Valid</span>, Soft Bounce, Hard Bounce</p>
                        <button class="btn btn-outline-primary btn-sm">Edit</button>
                    </div>
                </div>
            </div>

            <!-- Deployment Information -->
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Deployment Information</h5>
                        <p>TDL Configuration: Default TDL Config</p>
                        <p>General Configuration: Default General Config</p>
                        <p>Activation Date: 29-Jul-2006</p>
                        <p>Release: 4.1</p>
                        <button class="btn btn-outline-primary btn-sm">Edit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Address Information -->
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Address Information</h5>
                        <p>Address Line1: # 521</p>
                        <p>Address Line2: Miller Stop P.N Road</p>
                        <p>Country: India</p>
                        <p>State / UT: Tamil Nadu</p>
                        <p>City: Tirupur</p>
                    </div>
                </div>
            </div>

            <!-- Statutory Information -->
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Statutory Information</h5>
                        <p>TIN No.: </p>
                        <p>GST Registration Type: Regular</p>
                        <p><input type="checkbox" checked> Do Not Have GSTIN</p>
                        <p>GSTIN not available Reason:</p>
                        <button class="btn btn-outline-primary btn-sm">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Information Sections -->
@endsection