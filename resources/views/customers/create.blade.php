@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Customer Forms</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="#" method="post" enctype="multipart/form-data">
                                <!-- Top fields -->
                                <div class="row mb-5">
                                    <div class="col-md-3">
                                        <label class="form-label mb-2 fw-semibold">Customer ID</label>
                                        <input type="text" name="customer_id" class="form-control form-control-lg bg-light" value="{{ date('Y-md') }}-000095" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label mb-2 fw-semibold">Customer Type</label>
                                        <select id="customer_type" name="customer_type" class="form-control form-control-lg form-select border-primary">
                                            <option value="Agriculture" selected>Agriculture</option>
                                            <option value="Commercial">Commercial</option>
                                            <option value="Drinking">Drinking</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tabs -->
                                <div class="panel panel-primary">
                                    <div class="tab-menu-heading p-0 bg-light border-bottom-0">
                                        <div class="tabs-menu">
                                            <ul class="nav nav-tabs border-bottom-0" id="customerTabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active fw-semibold py-3 px-4" id="admin-land-tab" data-bs-toggle="tab" href="#admin-land" role="tab" aria-controls="admin-land" aria-selected="true"><span id="tab1-title">Administration & Land details</span></a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link fw-semibold py-3 px-4" id="details-tab" data-bs-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false"><span id="tab2-title">Land Owner/Khatedir Details</span></a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link fw-semibold py-3 px-4" id="attachments-tab" data-bs-toggle="tab" href="#attachments" role="tab" aria-controls="attachments" aria-selected="false">Attachments</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="panel-body tabs-menu-body p-0 pt-4">
                                        <div class="tab-content" id="customerTabsContent">
                                            
                                            <!-- TAB 1: Administration & Land details -->
                                            <div class="tab-pane fade show active" id="admin-land" role="tabpanel" aria-labelledby="admin-land-tab">
                                                
                                                <!-- Administration Section -->
                                                <div class="mt-4 mb-5">
                                                    <h5 class="fw-bold mb-3 text-dark" style="font-size: 16px;">Administration</h5>
                                                    <div class="row">
                                                        <div class="col-md-3 mb-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Region</label>
                                                            <select class="form-control form-select"><option>Select Region</option></select>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Circle</label>
                                                            <select class="form-control form-select"><option>Select Circle</option></select>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Division</label>
                                                            <select class="form-control form-select"><option>Select Division</option></select>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Sub-Division</label>
                                                            <select class="form-control form-select"><option>Select Sub-Division</option></select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Source of Irrigation Section -->
                                                <div class="mt-4 mb-5">
                                                    <h5 class="fw-bold mb-3 text-dark" style="font-size: 16px;">Source of Irrigation</h5>
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Water Source (Canal/Distributary)</label>
                                                            <select class="form-control form-select"><option>Select Water Source</option></select>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Water Course (Outlet)</label>
                                                            <select class="form-control form-select"><option>Select Water Course</option></select>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">District</label>
                                                            <select class="form-control form-select"><option>Select District</option></select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Taluka</label>
                                                            <select class="form-control form-select"><option>Select Taluka</option></select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Deh Name</label>
                                                            <select class="form-control form-select"><option>Select Deh</option></select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Land Details Section -->
                                                <div class="mt-4 mb-5" id="land-details-section">
                                                    <h5 class="fw-bold mb-3 text-dark" style="font-size: 16px;">Land Details</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Total GCA</label>
                                                            <input type="text" class="form-control" placeholder="0.00">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Total CCA</label>
                                                            <input type="text" class="form-control" placeholder="0.00">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Others</label>
                                                            <input type="text" class="form-control" placeholder="0.00">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Land Area (Acre)</label>
                                                            <input type="text" class="form-control" placeholder="0.00">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Gunthas</label>
                                                            <input type="text" class="form-control" placeholder="0.00">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Survey or Block</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Land Type</label>
                                                            <select class="form-control form-select">
                                                                <option>Normal</option>
                                                                <option>Barren</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Latitude</label>
                                                            <input type="text" class="form-control" placeholder="0.00">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Longitude</label>
                                                            <input type="text" class="form-control" placeholder="0.00">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <button type="button" class="btn btn-light border px-4">Save</button>
                                                    </div>

                                                    <!-- Land Details Table -->
                                                    <div class="table-responsive mb-2">
                                                        <table class="table table-bordered text-nowrap mb-0 w-100" style="font-size: 13px;">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th class="fw-bold text-dark border-bottom-0 py-2">Land Area (Acre)</th>
                                                                    <th class="fw-bold text-dark border-bottom-0 py-2">Gunthas</th>
                                                                    <th class="fw-bold text-dark border-bottom-0 py-2">Land Type</th>
                                                                    <th class="fw-bold text-dark border-bottom-0 py-2">Survey or Block</th>
                                                                    <th class="fw-bold text-dark border-bottom-0 py-2 text-center">Edit</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="py-2">12.00</td>
                                                                    <td class="py-2">12.00</td>
                                                                    <td class="py-2">Normal</td>
                                                                    <td class="py-2">12</td>
                                                                    <td class="py-2 text-center">
                                                                        <a href="javascript:void(0);" class="text-primary me-2">View/Edit</a> 
                                                                        <a href="javascript:void(0);" class="text-dark text-decoration-none"><i class="fa fa-image text-muted me-1"></i>Delete</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="py-2">12.00</td>
                                                                    <td class="py-2">12.00</td>
                                                                    <td class="py-2">Normal</td>
                                                                    <td class="py-2">12</td>
                                                                    <td class="py-2 text-center">
                                                                        <a href="javascript:void(0);" class="text-primary me-2">View/Edit</a> 
                                                                        <a href="javascript:void(0);" class="text-dark text-decoration-none"><i class="fa fa-image text-muted me-1"></i>Delete</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="mb-3 text-end" style="font-size: 14px; font-weight: 500; color: #777;">
                                                        Total Land Area (Acre) <span class="text-dark ms-1 me-3">24.00</span> 
                                                        Total Gunthas: <span class="text-dark ms-1">24.00</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- TAB 2: Details (Dynamic based on type) -->
                                            <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                                                
                                                <!-- Agriculture Details (Owner/Occupier) -->
                                                <div id="agriculture-details-section">
                                                    <div class="mt-4 mb-5">
                                                        <h5 class="fw-bold mb-3 text-dark" style="font-size: 16px;">Customer Owner Details</h5>
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Owner Name</label>
                                                                <input type="text" class="form-control" placeholder="Enter owner name">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Father Name</label>
                                                                <input type="text" class="form-control" placeholder="Enter father name">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Owner CNIC</label>
                                                                <input type="text" class="form-control" placeholder="00000-0000000-0">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Mobile No</label>
                                                                <input type="text" class="form-control" placeholder="0300-0000000">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Email</label>
                                                                <input type="email" class="form-control" placeholder="Email Address">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">City/Town</label>
                                                                <input type="text" class="form-control" placeholder="Enter city/town">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Complete Address</label>
                                                                <textarea class="form-control" rows="2" placeholder="Enter full address here..."></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-4 mb-5">
                                                        <h5 class="fw-bold mb-3 text-dark" style="font-size: 16px;">Occupier Details</h5>
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Occupier Type</label>
                                                                <select class="form-control form-select">
                                                                    <option value="">Select Type</option>
                                                                    <option value="Guardian">Guardian</option>
                                                                    <option value="Rented">Rented</option>
                                                                    <option value="New Owner">New Owner</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Occupier Name</label>
                                                                <input type="text" class="form-control" placeholder="Enter occupier name">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Occupier Father Name</label>
                                                                <input type="text" class="form-control" placeholder="Enter father name">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Occupier CNIC</label>
                                                                <input type="text" class="form-control" placeholder="00000-0000000-0">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Mobile No</label>
                                                                <input type="text" class="form-control" placeholder="0300-0000000">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Email</label>
                                                                <input type="email" class="form-control" placeholder="Email Address">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">City/Town</label>
                                                                <input type="text" class="form-control" placeholder="Enter city/town">
                                                            </div>
                                                            <div class="col-md-8 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Occupier Address</label>
                                                                <input type="text" class="form-control" placeholder="Complete address">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Commercial Details (Company/Organization) -->
                                                <div id="commercial-details-section" style="display:none;">
                                                    <div class="mt-4 mb-5">
                                                        <h5 class="fw-bold mb-3 text-dark" style="font-size: 16px;">Company/Organization Details</h5>
                                                        <div class="row">
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Company/Organization</label>
                                                                <input type="text" class="form-control" placeholder="Enter company name">
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Scheme Name</label>
                                                                <input type="text" class="form-control" placeholder="Enter scheme name">
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Sanction Dishcarge (Cusecs)</label>
                                                                <input type="text" class="form-control" placeholder="0.00">
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Water Rate (Per 1000 Gallons)</label>
                                                                <input type="text" class="form-control" placeholder="0.00">
                                                            </div>
                                                            
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Security Deposit</label>
                                                                <input type="text" class="form-control" placeholder="0.00">
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Location</label>
                                                                <input type="text" class="form-control" placeholder="Enter location">
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Sanction Order NO</label>
                                                                <input type="text" class="form-control" placeholder="Enter order no">
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Sanction Order Date</label>
                                                                <input type="date" class="form-control">
                                                            </div>

                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Agreement From</label>
                                                                <input type="date" class="form-control">
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Agreement To</label>
                                                                <input type="date" class="form-control">
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" style="font-weight: 500; font-size: 13px;">Agreement No</label>
                                                                <input type="text" class="form-control" placeholder="Enter agreement no">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- TAB 3: Attachments -->
                                            <div class="tab-pane fade" id="attachments" role="tabpanel" aria-labelledby="attachments-tab">
                                                <div class="mt-4 mb-5">
                                                    <h5 class="fw-bold mb-3 text-dark" style="font-size: 16px;">Document Attachments</h5>
                                                    
                                                    <div class="row align-items-end mb-4">
                                                        <div class="col-md-5 mb-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Attachment Name</label>
                                                            <input type="text" class="form-control" placeholder="e.g. CNIC Copy">
                                                        </div>
                                                        <div class="col-md-5 mb-3">
                                                            <label class="form-label" style="font-weight: 500; font-size: 13px;">Upload Attachment</label>
                                                            <input class="form-control" type="file" id="formFile">
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <button type="button" class="btn btn-light border w-100">Upload</button>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover mb-0" style="font-size: 13px;">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th class="fw-bold text-dark border-bottom-0 py-2">Attachment Name</th>
                                                                    <th class="fw-bold text-dark border-bottom-0 py-2">File Name</th>
                                                                    <th class="fw-bold text-dark border-bottom-0 py-2 text-center" style="width: 150px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="3" class="text-center text-muted py-4">
                                                                        No attachments added yet.
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-light border px-4 me-2">Submit</button>
                                    <a href="{{ route('customers.index') }}" class="btn btn-light border px-4">Cancel</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('JScript')
<script>
    (function() {
        const customerTypeSelect = document.getElementById('customer_type');
        
        // Tab 1 Elements
        const landDetailsSection = document.getElementById('land-details-section');
        const tab1Title = document.getElementById('tab1-title');
        
        // Tab 2 Elements
        const tab2Title = document.getElementById('tab2-title');
        const agricultureDetails = document.getElementById('agriculture-details-section');
        const commercialDetails = document.getElementById('commercial-details-section');

        if (!customerTypeSelect) return;

        customerTypeSelect.addEventListener('change', function() {
            if (this.value === 'Commercial' || this.value === 'Drinking') {
                // Tab 1 adjustments
                if(landDetailsSection) landDetailsSection.style.display = 'none';
                if(tab1Title) tab1Title.textContent = 'Administration';
                
                // Tab 2 adjustments
                if(tab2Title) tab2Title.textContent = 'Company/Organization Details';
                if(agricultureDetails) agricultureDetails.style.display = 'none';
                if(commercialDetails) commercialDetails.style.display = 'block';
            } else {
                // Tab 1 adjustments (Agriculture default behavior)
                if(landDetailsSection) landDetailsSection.style.display = 'block';
                if(tab1Title) tab1Title.textContent = 'Administration & Land details';
                
                // Tab 2 adjustments
                if(tab2Title) tab2Title.textContent = 'Land Owner/Khatedir Details';
                if(agricultureDetails) agricultureDetails.style.display = 'block';
                if(commercialDetails) commercialDetails.style.display = 'none';
            }
        });

        // Initialize form state immediately
        customerTypeSelect.dispatchEvent(new Event('change'));
    })();
</script>
@endsection
