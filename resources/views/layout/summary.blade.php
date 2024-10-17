<style>
    .card:hover {
        transform: scale(1.05);
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
    }


</style>
<div class="container-fluid">
    <div class="row">

        <!-- Product Card -->
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 animated fadeIn p-2">
            <div class="card h-100 bg-white p-4 shadow-sm" style="border-radius: 15px; transition: transform 0.2s;">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="mb-1 text-capitalize font-weight-bold">
                            <span id="product"></span>
                        </h5>
                        <p class="mb-0 text-muted">Product</p>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-container shadow-sm bg-gradient-primary"
                             style="width: 50px; height: 50px; border-radius: 50%; padding: 5px; transition: 0.2s;">
                            <img class="w-100 h-100 rounded-circle" src="{{asset('images/icon.svg')}}" alt="Product Icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Card -->
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 animated fadeIn p-2">
            <div class="card h-100 bg-white p-4 shadow-sm" style="border-radius: 15px; transition: transform 0.2s;">
                <div class="row align-items-center">
                    <div class="col-8">
                        <a href="{{url('/categoryPage')}}" class="text-decoration-none">
                            <h5 class="mb-1 text-capitalize font-weight-bold">
                                <span id="category"></span>
                            </h5>
                            <p class="mb-0 text-muted">Category</p>
                        </a>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-container shadow-sm bg-gradient-primary"
                             style="width: 50px; height: 50px; border-radius: 50%; padding: 5px; transition: 0.2s;">
                            <img class="w-100 h-100 rounded-circle" src="{{asset('images/icon.svg')}}" alt="Category Icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Card -->
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 animated fadeIn p-2">
            <div class="card h-100 bg-white p-4 shadow-sm" style="border-radius: 15px; transition: transform 0.2s;">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="mb-1 text-capitalize font-weight-bold">
                            <span id="customer"></span>
                        </h5>
                        <p class="mb-0 text-muted">Customer</p>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-container shadow-sm bg-gradient-primary"
                             style="width: 50px; height: 50px; border-radius: 50%; padding: 5px; transition: 0.2s;">
                            <img class="w-100 h-100 rounded-circle" src="{{asset('images/icon.svg')}}" alt="Customer Icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Card -->
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 animated fadeIn p-2">
            <div class="card h-100 bg-white p-4 shadow-sm" style="border-radius: 15px; transition: transform 0.2s;">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="mb-1 text-capitalize font-weight-bold">
                            <span id="invoice"></span>
                        </h5>
                        <p class="mb-0 text-muted">Invoice</p>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-container shadow-sm bg-gradient-primary"
                             style="width: 50px; height: 50px; border-radius: 50%; padding: 5px; transition: 0.2s;">
                            <img class="w-100 h-100 rounded-circle" src="{{asset('images/icon.svg')}}" alt="Invoice Icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Sale Card -->
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 animated fadeIn p-2">
            <div class="card h-100 bg-white p-4 shadow-sm" style="border-radius: 15px; transition: transform 0.2s;">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="mb-1 text-capitalize font-weight-bold">
                            $ <span id="total"></span>
                        </h5>
                        <p class="mb-0 text-muted">Total Sale</p>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-container shadow-sm bg-gradient-primary"
                             style="width: 50px; height: 50px; border-radius: 50%; padding: 5px; transition: 0.2s;">
                            <img class="w-100 h-100 rounded-circle" src="{{asset('images/icon.svg')}}" alt="Total Sale Icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Collection Card -->
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 animated fadeIn p-2">
            <div class="card h-100 bg-white p-4 shadow-sm" style="border-radius: 15px; transition: transform 0.2s;">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="mb-1 text-capitalize font-weight-bold">
                            $ <span id="payable"></span>
                        </h5>
                        <p class="mb-0 text-muted">Total Collection</p>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-container shadow-sm bg-gradient-primary"
                             style="width: 50px; height: 50px; border-radius: 50%; padding: 5px; transition: 0.2s;">
                            <img class="w-100 h-100 rounded-circle" src="{{asset('images/icon.svg')}}" alt="Total Collection Icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
