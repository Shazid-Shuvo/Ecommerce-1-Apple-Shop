@extends('layout.side-nav')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Add New Product</h4>
                    </div>
                    <div class="card-body">
                      <form enctype="multipart/form-data" id="save-form">

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" required>
                            </div>

                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Enter product title" required>
                            </div>

                            <!-- Short Description -->
                            <div class="mb-3">
                                <label for="short_des" class="form-label">Short Description</label>
                                <textarea name="short_des" id="short_des" class="form-control" rows="3" placeholder="Enter a short description" required></textarea>
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" id="price" class="form-control" step="0.01" placeholder="Enter price" required>
                            </div>

                            <!-- Discount -->
                            <div class="mb-3">
                                <label for="discount" class="form-label">Discount (%)</label>
                                <input type="number" name="discount" id="discount" class="form-control" step="0.01" placeholder="Enter discount percentage">
                            </div>

                            <!-- Discounted Price -->
                            <div class="mb-3">
                                <label for="discount_price" class="form-label">Discounted Price</label>
                                <input type="number" name="discount_price" id="discount_price" class="form-control" step="0.01" placeholder="Enter discounted price">
                            </div>

                            <!-- Stock -->
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" name="stock" id="stock" class="form-control" placeholder="Enter stock quantity" required>
                            </div>

                            <!-- Star Rating -->
                            <div class="mb-3">
                                <label for="star" class="form-label">Star Rating</label>
                                <input type="number" name="star" id="star" class="form-control" step="0.1" max="5" min="0" placeholder="Enter star rating (0-5)">
                            </div>


                            <div class="mb-3">
                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label">Image</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="image">

                            </div>

                            <!-- Remark -->
                            <div class="mb-3">
                                <label for="remark" class="form-label">Remark</label>
                                <select name="remark" id="remark" class="form-control form-select">
                                    <option value="" selected disabled>Select a Remark</option>
                                    <option value="popular">Popular</option>
                                    <option value="new">New</option>
                                    <option value="top">Top</option>
                                    <option value="special">Special</option>
                                    <option value="trending">Trending</option>
                                    <option value="regular">Regular</option>
                                </select>
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-control form-select" id="productCategory" required>
                                    <option value="">Select Category</option>
                                </select>
                            </div>

                        <div class="mb-3">
                            <label class="form-label">Brand</label>
                            <select class="form-control form-select" id="productBrand" required>
                                <option value="">Select Brand</option>
                            </select>
                        </div>



                        <div class="text-center">
                                <button type="submit" onclick="AddProductForm() " class="btn btn-primary">Add Product</button>
                            </div>
                   </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        FillCategoryDropDown();
        FillBrandDropDown();
        async function FillCategoryDropDown(){
            let res = await axios.get("/CategoryList")
            res.data.data.forEach(function (item,i) {
                let option=`<option  value="${item['id']}">${item['categoryName']}</option>`
                $("#productCategory").append(option);
            })
        }

        async function FillBrandDropDown() {
            try {
                let res = await axios.get("/BrandList"); // Get brand list from server

                res.data.data.forEach(function (item,i) {
                    let option=`<option value="${item['id']}">${item['brandName']}</option>`
                    $("#productBrand").append(option);
                })

            } catch (error) {
                console.error("Error fetching brands:", error);
            }
        }


        function getSelectedBrand() {
            let brand = document.getElementById('brand').value;

            if (brand) {
                console.log("Selected Brand ID:", brand);
            } else {
                console.log("No brand selected");
            }
        }

        // async function FillBrandDropDown(){
        //     let res = await axios.get("/BrandList")
        //     res.data.data.forEach(function (item,i) {
        //         let option=`<option value="${item['id']}">${item['brandName']}</option>`
        //         $("#brand").append(option);
        //     })
        // }

        async function AddProductForm() {
            // try {
                // Get input values
                let name = document.getElementById('name').value;
                let title = document.getElementById('title').value;
                let shortDes = document.getElementById('short_des').value;
                let price = document.getElementById('price').value;
                let discount = document.getElementById('discount').value;
                let discountPrice = document.getElementById('discount_price').value;
                let stock = document.getElementById('stock').value;
                let star = document.getElementById('star').value;
                let remark = document.getElementById('remark').value;
                let category = document.getElementById('productCategory').value;
                let brand = document.getElementById('productBrand').value;
                let productImg = document.getElementById('image').files[0];

                alert(category);
                alert(brand);

                if(category.length === 0) {
                    errorToast("Product Category Required!");
                } else if (name.length === 0) {
                    errorToast("Product Name Required!");
                } else if (price.length === 0) {
                    errorToast("Product Price Required!");
                } else if (title.length === 0) {
                    errorToast("Product Title Required!");
                } else if (shortDes.length === 0) {
                    errorToast("Product Description Required!");
                } else if (discount.length === 0) {
                    errorToast("Product Discount Required!");
                } else if (discountPrice.length === 0) {
                    errorToast("Product Discount Price Required!");
                } else if (stock.length === 0) {
                    errorToast("Product Stock Required!");
                } else if (!productImg) {
                    errorToast("Product Image Required!");
                } else {
                    // Create FormData object to send via POST request
                    let formData = new FormData();
                    formData.append('name', name);
                    formData.append('title', title);
                    formData.append('short_des', shortDes);
                    formData.append('price', price);
                    formData.append('discount', discount);
                    formData.append('discount_price', discountPrice);
                    formData.append('stock', stock);
                    formData.append('star', star);
                    formData.append('remark', remark);
                    formData.append('category', category);
                    formData.append('brand', brand);
                    formData.append('image', productImg);

                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data',

                        }
                    };

                    // showLoader();
                    // console.log("Submitting product data...");

                    let res = await axios.post("/AddProduct", formData, config);
                    // hideLoader();

                    if (res.status === 200 || res.status === 201) {
                        successToast('Product created successfully!');
                        // document.getElementById("save-form").reset();  // Reset form
                    } else {
                        errorToast(res.message);
                    }
                }
            // } catch (e) {
            //     alert(e);
            //     console.error("Error:", e ,res.messa);
            // }
        }


    </script>

    @endsection



