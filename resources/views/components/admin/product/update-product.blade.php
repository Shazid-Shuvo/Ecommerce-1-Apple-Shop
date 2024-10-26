<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <form id="update-form">
                                    <input type="hidden" id="updateID">
                                    <input type="hidden" id="filePath">

                                    <label class="form-label mt-2">Name</label>
                                    <input type="text" class="form-control" id="UproductName">

                                    <label class="form-label mt-2">Title</label>
                                    <input type="text" class="form-control" id="UproductTitle">

                                    <label class="form-label mt-2">Short Description</label>
                                    <input type="text" class="form-control" id="UproductDes">

                                    <label class="form-label mt-2">Price</label>
                                    <input type="text" class="form-control" id="UproductPrice">

                                    <label class="form-label mt-2">Discount Percentage</label>
                                    <input type="text" class="form-control" id="UproductDiscount">

                                    <label class="form-label mt-2">Discount Price</label>
                                    <input type="text" class="form-control" id="UproductDisPrc">

                                    <label class="form-label mt-2">Stock</label>
                                    <input type="text" class="form-control" id="UproductStock">

                                    <label class="form-label mt-2">Star</label>
                                    <input type="text" class="form-control" id="UproductStar">

                                    <label class="form-label mt-2">Remark</label>
                                    <select class="form-control form-select" id="UproductRemark">
                                        <option value="popular">Popular</option>
                                        <option value="new">New</option>
                                        <option value="top">Top</option>
                                        <option value="special">Special</option>
                                        <option value="trending">Trending</option>
                                    </select>

                                    <img class="w-15 mt-3" id="oldImg" src="{{asset('images/default.jpg')}}"/>
                                    <input type="file" class="form-control mt-2" id="UproductImg"
                                           oninput="document.getElementById('oldImg').src = window.URL.createObjectURL(this.files[0])">

                                    <label class="form-label mt-2">Brand</label>
                                    <select class="form-control form-select" id="UproductBrand"></select>

                                    <label class="form-label mt-2">Category</label>
                                    <select class="form-control form-select" id="UproductCategory"></select>
                                </form>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="save-btn" class="btn bg-gradient-success" >Update</button>
            </div>
        </div>
    </div>
</div>


<script>



    // Initialize dropdowns when the page loads
    $(document).ready(() => {
        FillBrandDropDown();
        FillCategoryDropDown();
    });

    // Fill the Category Dropdown
    async function FillCategoryDropDown() {
        let res = await axios.get("/CategoryList");
        res.data.data.forEach((item) => {
            let option = `<option value="${item.id}">${item.categoryName}</option>`;
            $("#UproductCategory").append(option); // Correct selector
        });
    }

    // Fill the Brand Dropdown
    async function FillBrandDropDown() {
        let res = await axios.get("/BrandList");
        res.data.data.forEach((item) => {
            let option = `<option value="${item.id}">${item.brandName}</option>`;
            $("#UproductBrand").append(option); // Correct selector
        });
    }

    async function FillUpUpdateForm(id, filePath) {
        $('#updateID').val(id);
        $('#filePath').val(filePath);
        $('#oldImg').attr('src', filePath);

        try {
            showLoader();

            // Make the POST request to fetch the product
            let res = await axios.post("/ProductById", { id: id });

            if (res.status === 200 && res.data.data) {
                hideLoader();

                let product = res.data.data; // Store the product object

                // Fill the form fields with product data
                document.getElementById('UproductName').value = product.name;
                document.getElementById('UproductTitle').value = product.title;
                document.getElementById('UproductDes').value = product.short_des;
                document.getElementById('UproductPrice').value = product.price;
                document.getElementById('UproductDiscount').value = product.discount;
                document.getElementById('UproductDisPrc').value = product.discount_price;
                document.getElementById('UproductStock').value = product.stock;
                document.getElementById('UproductStar').value = product.star;
                document.getElementById('UproductRemark').value = product.remark;
                document.getElementById('UproductCategory').value = product.category_id;
                document.getElementById('UproductBrand').value = product.brand_id;

                // Show the modal
                $('#update-modal').modal('show');
            } else {
                throw new Error('Product not found');
            }
        } catch (error) {
            hideLoader();
            console.error('Error fetching product details:', error);
            alert('Failed to load product details.');
        }
    }


    async function Update() {
        try {
            let productName = document.getElementById('UproductName').value;
            let productTitle = document.getElementById('UproductTitle').value;
            let productDes = document.getElementById('UproductDes').value;
            let productPrice = document.getElementById('UproductPrice').value;
            let productDisPer = document.getElementById('UproductDiscount').value;
            let productDisPrc = document.getElementById('UproductDisPrc').value;
            let productStock = document.getElementById('UproductStock').value;
            let productStar= document.getElementById('UproductStar').value;
            let productRemark = document.getElementById('UproductRemark').value;
            let productCategory = document.getElementById('UproductCategory').value;
            let productBrand = document.getElementById('UproductBrand').value;
            let productImg = document.getElementById('UproductImg').files[0];
            let updateID=document.getElementById('updateID').value;
            let filePath=document.getElementById('filePath').value;

            if (productCategory.length === 0) {
                errorToast("Product Category Required !")
            } else if (productTitle.length === 0) {
                errorToast("Product Title Required !")
            } else if (productPrice.length === 0) {
                errorToast("Product Price Required !")
            } else if (productDes.length === 0) {
                errorToast("Product Description Required !")
            }
            else if (productDisPrc.length === 0) {
                errorToast("Product Discount price Required !")
            }
            else if (productDisPer.length === 0) {
                errorToast("Product Discount Required !")
            }
            else if (productStock.length === 0) {
                errorToast("Product quantity Required !")
            }
            else if (productStar.length === 0) {
                errorToast("Product Star Required !")
            }
            else if (productRemark.length === 0) {
                errorToast("Product Remark Required !")
            } else if (productBrand.length === 0) {
                errorToast("Product Brand Required !")
            }else {

                document.getElementById('modal-close').click();

                let formData = new FormData();
                formData.append('name', productName)
                formData.append('title', productTitle)
                formData.append('short_des', productDes)
                formData.append('price', productPrice)
                formData.append('discount', productDisPer)
                formData.append('discount_price', productDisPrc)
                formData.append('stock', productStock)
                formData.append('star', productStar)
                formData.append('remark', productRemark)
                formData.append('category', productCategory)
                formData.append('brand', productBrand)
                formData.append('image', productImg)
                formData.append('file_path',filePath)
                formData.append('id',updateID)

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                showLoader();
                let res = await axios.post("/UpdateProduct", formData, config)
                hideLoader();

                if (res.status === 201 || res.status === 200) {
                    successToast('Request completed');
                    document.getElementById("update-form").reset();
                    await productList();
                } else {
                    errorToast("Request fail !")
                }
            }
        }
        catch (e) {
            alert(e);
        }
    }
</script>
