<style>
    .product {
        border: 1px solid #e2e2e2;
        margin-bottom: 20px;
        padding: 15px;
        background-color: #fff;
        transition: all 0.3s ease;
        height: 100%; /* Make sure product cards take the full height */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product_img img {
        width: 100%; /* Ensure images are responsive */
        height: 200px; /* Set a fixed height */
        object-fit: cover; /* Maintain aspect ratio and avoid distortion */
    }

    .product_info {
        margin-top: 15px;
    }

    .product_info h6 {
        min-height: 50px; /* Prevent text overflow from collapsing */
        overflow: hidden;
    }

    /* Ensure consistent height across cards */
    .product_price {
        min-height: 30px;
    }
    .product_title a {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }

</style>

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Category: <span id="CatName"></span></h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{url("/HomePage")}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">This Page</a></li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<div class="mt-5">
    <div class="container my-5">
        <div id="byCategoryList" class="row">

        </div>
    </div>
</div>
<script>

    async function ProductByCategory() {
        let searchParams = new URLSearchParams(window.location.search);
        let id = searchParams.get('id');

        showLoader();
        let res = await axios.get(`/ListProductByCategory/${id}`);
        hideLoader();

        $("#byCategoryList").empty();
        res.data['data'].forEach((item) => {
            let EachItem = `
            <div class="col-lg-3 col-md-4 col-6 d-flex">
                <div class="product card w-100">
                    <div class="product_img card-img-top">
                        <a href="/ProductDetailsPage?id=${item['id']}">
                            <img src="${item['image']}" alt="product_img9" class="img-fluid">
                        </a>
                    </div>
                    <div class="card-body product_info">
                        <h6 class="product_title">
                            <a href="/ProductDetailsPage?id=${item['id']}">${item['title']}</a>
                        </h6>
                        <div class="product_price">
                            <span class="price">$ ${item['price']}</span>
                        </div>
                        <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width:${item['star']}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
            $("#byCategoryList").append(EachItem);
        });
    }

</script>
