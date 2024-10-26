<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label mt-2">Name</label>
                                <input type="text" class="form-control" id="productName">

                                <label class="form-label mt-2">Title</label>
                                <input type="text" class="form-control" id="productTitle">

                                <label class="form-label mt-2">Short Description</label>
                                <input type="text" class="form-control" id="productDes">

                                <label class="form-label mt-2">Price</label>
                                <input type="text" class="form-control" id="productPrice">

                                <label class="form-label mt-2">Discount Percentage</label>
                                <input type="text" class="form-control" id="productDiscount">

                                <label class="form-label mt-2">Discount Price</label>
                                <input type="text" class="form-control" id="productDisPrc">

                                <label class="form-label mt-2">stock</label>
                                <input type="text" class="form-control" id="productStock">

                                <label class="form-label mt-2">Star</label>
                                <input type="text" class="form-control" id="productStar">

                                <label class="form-label mt-2">Remark</label>
                                <select type="text" class="form-control form-select" id="productRemark">
                                    <option value="popular">Popular</option>
                                    <option value="new">New</option>
                                    <option value="top">Top</option>
                                    <option value="special">Special</option>
                                    <option value="trending">Trending</option>
                                </select>

                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label">Image</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImg">

                                <label class="form-label">Brand</label>
                                <select type="text" class="form-control form-select" id="productBrand">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategory">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
            </div>
        </div>
    </div>
</div>


<script>


    FillBrandDropDown();
    FillCategoryDropDown();

    async function FillCategoryDropDown(){
        let res = await axios.get("/CategoryList")
        res.data.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['categoryName']}</option>`
            $("#productCategory").append(option);
        })
    }
    async function FillBrandDropDown(){
        let res = await axios.get("/BrandList")
        res.data.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['brandName']}</option>`
            $("#productBrand").append(option);
        })
    }


    async function Save() {
        try {
            let productName = document.getElementById('productName').value;
            let productTitle = document.getElementById('productTitle').value;
            let productDes = document.getElementById('productDes').value;
            let productPrice = document.getElementById('productPrice').value;
            let productDisPer = document.getElementById('productDiscount').value;
            let productDisPrc = document.getElementById('productDisPrc').value;
            let productStock = document.getElementById('productStock').value;
            let productStar= document.getElementById('productStar').value;
            let productRemark = document.getElementById('productRemark').value;
            let productCategory = document.getElementById('productCategory').value;
            let productBrand = document.getElementById('productBrand').value;
            let productImg = document.getElementById('productImg').files[0];

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
            }else if (!productImg) {
                errorToast("Product Image Required !")
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

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                showLoader();
                let res = await axios.post("/AddProduct", formData, config)
                hideLoader();

                if (res.status === 201 || res.status === 200) {
                    successToast('Request completed');
                    document.getElementById("save-form").reset();
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
