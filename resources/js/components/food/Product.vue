<template>
    <div>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">ម្ហូបអាហារ</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/home">ទំព័រដើម</a></li>
                                <li class="breadcrumb-item active">ម្ហូបអាហារ</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <button type="button"
                                                @click="newProduct"
                                                class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-plus"></i>
                                            ម្ហូបអាហារថ្មី
                                        </button>

                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 8%;">ម្ហូបអាហារ</th>
                                            <th style="width: 20%;"></th>
                                            <th style="width: 20%;">បរិយាយ</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="pro in products.data" :key="pro.id">
                                            <td>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <img alt="Avatar" v-bind:src="'img/food/' + pro.photo" class="table-avatar">
                                                    </li>
                                                </ul>
                                            </td>

                                            <td>
                                                <strong>{{ pro.name + " - " + pro.name_kh }}</strong>
                                                <br>
                                                <small>តម្លៃ {{ pro.price }}</small>
                                            </td>
                                            <td>{{ pro.dsc }}</td>

                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-folder"></i> មើល
                                                    </button>
                                                    <button type="button" @click="infoProduct(pro)" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-pencil-alt"></i> កែប្រែ
                                                    </button>
                                                    <button type="button" @click="deleteProduct(pro.id)" class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-trash"></i> លុប
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <pagination :data="products"
                                                @pagination-change-page="getProduct"
                                                :limit="2" align="right" size="small">
                                    </pagination>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>

        <div class="modal fade" id="modal-product">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="method ? editProduct() : createProduct()" role="form" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">ព័ត៌មានម្ហូបអាហារ</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">ឈ្មោះម្ហូបអាហារ</label>
                                <input type="text" class="form-control"
                                       v-model="form.name"
                                       name="name" id="name"
                                       placeholder="ឈ្មោះម្ហូបអាហារ" autocomplete="name" autofocus required>
                            </div>
                            <div class="form-group">
                                <label for="name_kh">ឈ្មោះម្ហូបអាហារ (ខ្មែរ)</label>
                                <input type="text" class="form-control"
                                       v-model="form.name_kh"
                                       name="name_kh" id="name_kh"
                                       placeholder="ឈ្មោះម្ហូបអាហារ (ខ្មែរ)" autocomplete="name_kh" required>
                            </div>
                            <div class="form-group">
                                <label for="price">តម្លៃ (រៀល)</label>
                                <input type="text" class="form-control"
                                       v-model="form.price"
                                       name="name_kh" id="price"
                                       placeholder="តម្លៃ (រៀល)" autocomplete="price" required>
                            </div>
                            <div class="form-group">
                                <label for="dsc">បរិយាយ</label>
                                <textarea class="form-control" rows="3"
                                          v-model="form.dsc"
                                          name="dsc" id="dsc"
                                          placeholder="បរិយាយ" autocomplete="dsc">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">រូបភាព</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" @change="onImageChange" name="photo" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">រើសរើស រូបភាព</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times">&nbsp;</i> បោះបង់</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save">&nbsp;</i> រក្សាទុក</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</template>

<script>
    import bsCustomFileInput from 'bs-custom-file-input';
    export default {
        data(){
            return{
                method:false,
                products: {},
                form: new Form({
                    id:"",
                    name:"",
                    name_kh:"",
                    price:"",
                    photo:"",
                    dsc:"",
                    category:1,
                    _token: token,
                })
            }
        },
        mounted() {
            this.getProduct();
            this.chooseImage();
            //Save Data not need refresh page
            Fire.$on('onCreated',(page = 1) => {
                this.getProduct(page);
            });
        },
        methods:{
            newProduct(){
                this.method = false;
                this.form.reset();
                $('#modal-product').modal('show');
            },
            getProduct(p = 1){
                axios.get('product/rows?page=' + p)
                    .then(res => {
                        this.products = res.data;
                        console.log(res.data)
                    })
                    .catch(err => console.log(err));
            },
            infoProduct(pro){
                this.method = true;
                this.form.reset();
                this.form.fill(pro);
                $('#modal-product').modal('show');
            },
            deleteProduct(id){

            },
            editProduct(){
                this.form.put('product/' +this.form.id).then(res =>{
                    Fire.$emit('onCreated',this.products.current_page);
                    $('#modal-product').modal('hide');
                }).catch(err => console.log(err));
            },
            createProduct(){
                this.form.post('product').then(res =>{
                    Fire.$emit('onCreated',1);
                    $('#modal-product').modal('hide');
                    console.log(res);
                }).catch(err => console.log(err));
            },
            chooseImage(){
                bsCustomFileInput.init();
            },
            onImageChange(event){
                let files = event.target.files;
                if(!files.length) return;

                let reader = new FileReader()
                reader.onload = (file) =>{
                    this.form.photo = file.target.result;
                }
                reader.readAsDataURL(files[0]);
            }
        }
    }
</script>

<style>
    img.table-avatar,
    .table-avatar img {
        border-radius: 50%;
        display: inline;
        width: 2.5rem;
    }
</style>
