@extends('template.app')
@section('title', 'Dashboard')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">

            <!-- Profit -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3 bg-light-primary rounded p-2">
                                <i class="bx bx-line-chart text-primary fs-3"></i>
                            </div>
                            <div>
                                <span class="fw-semibold d-block mb-1">Profit</span>
                                <h3 class="card-title mb-2">$12,628</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3 bg-light-info rounded p-2">
                                <i class="bx bx-wallet text-info fs-3"></i>
                            </div>
                            <div>
                                <span class="fw-semibold d-block mb-1">Sales</span>
                                <h3 class="card-title mb-2">$4,679</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payments -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3 bg-light-danger rounded p-2">
                                <i class="bx bxl-paypal text-danger fs-3"></i>
                            </div>
                            <div>
                                <span class="fw-semibold d-block mb-1">Payments</span>
                                <h3 class="card-title mb-2">$2,456</h3>
                                <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3 bg-light-success rounded p-2">
                                <i class="bx bx-credit-card text-success fs-3"></i>
                            </div>
                            <div>
                                <span class="fw-semibold d-block mb-1">Transactions</span>
                                <h3 class="card-title mb-2">$14,857</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt1">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
@endpush
