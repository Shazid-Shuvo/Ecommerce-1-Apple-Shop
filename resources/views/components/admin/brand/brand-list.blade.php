<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between">
                    <div class="align-items-center col">
                        <h4>Brand</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-secondary"/>
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Brand</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="tableList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    brandList();


    async function brandList() {


        showLoader();
        let res=await axios.get("/BrandList");
        hideLoader();

        let tableList=$("#tableList");
        let tableData=$("#tableData");

        tableData.DataTable().destroy();
        tableList.empty();

        res.data.data.forEach(function (item,index){
            let row=`<tr>
                    <td>${index+1}</td>
                    <td>${item['brandName']}</td>
                     <td><img class="w-15 h-auto" alt="" src="${item['brandImg']}"></td>
                    <td>
                        <button data-id="${item['id']}" data-path="${item['brandImg']}"   data-name="${item['brandName']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                        <button data-id="${item['id']}" data-path="${item['brandImg']}"  data-name="${item['brandName']}"  class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                    </td>
                 </tr>`
            tableList.append(row)
        })
        $('.editBtn').on('click',function (){
            let id= $(this).data('id');
            let BName = $(this).data('name');
            let filePath = $(this).data('path');
            $("#update-modal").modal('show');
            $("#updateID").val(id)
            $("#brandNameUpdate").val(BName)
            $("#filePath").val(filePath)
        })
        $('.deleteBtn').on('click',function (){
            let id= $(this).data('id');
            let filePath = $(this).data('path');
            $("#delete-modal").modal('show');
            $("#deleteID").val(id)
            $("#deleteFilePath").val(filePath)
        })
        new DataTable('#tableData',{
            order:[[0,'asc']],
            lengthMenu:[5,10,15,20,30]
        });

    }

</script>

