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
                                    <div class="card-body p-0">
                                        <ul class="products-list product-list-in-card pl-2 pr-2">
                                            <li class="item" v-for="pro in products.data" :key="pro.id">
                                                <div class="product-img">
                                                    <img v-bind:src="'img/food/' + pro.photo" alt="Product" class="img-size-50">
                                                </div>
                                                <div class="product-info">
                                                    <a href="javascript:void(0)" class="product-title">{{ pro.name + " - " + pro.name_kh }} &nbsp;
                                                        <span class="badge badge-danger text-font-14">{{ pro.price }}៛</span>

                                                        <span class="badge badge-primary text-font-14">{{ pro.category_name}}</span>
                                                    </a>
                                                    <span class="product-description">
                                                        {{ pro.dsc }}

                                                        <div class="float-right">
                                                            <div class="btn-group">
                                                                <button type="button" @click="infoProduct(pro)" class="btn btn-outline-primary btn-sm">
                                                                    <i class="fas fa-pencil-alt"></i> កែប្រែ
                                                                </button>
                                                                <button type="button" @click="deleteProduct(pro.id)" class="btn btn-outline-danger btn-sm">
                                                                    <i class="fas fa-trash"></i> លុប
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

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
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form @submit.prevent="method ? editProduct() : createProduct()" role="form" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title">ព័ត៌មានម្ហូបអាហារ</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="name">ឈ្មោះម្ហូបអាហារ</label>
                                            <input type="text" class="form-control" :class="{ 'is-invalid' : form.errors.has('name') }"
                                                   v-model="form.name"
                                                   name="name" id="name"
                                                   placeholder="ឈ្មោះម្ហូបអាហារ" autocomplete="name" autofocus>
                                            <has-error :form="form" field="name"></has-error>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="name_kh">ឈ្មោះម្ហូបអាហារ (ខ្មែរ)</label>
                                            <input type="text" class="form-control" :class="{ 'is-invalid' : form.errors.has('name_kh') }"
                                                   v-model="form.name_kh"
                                                   name="name_kh" id="name_kh"
                                                   placeholder="ឈ្មោះម្ហូបអាហារ (ខ្មែរ)" autocomplete="name_kh">
                                            <has-error :form="form" field="name_kh"></has-error>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="price">តម្លៃ (រៀល)</label>
                                            <input type="number" min="0" class="form-control" :class="{ 'is-invalid' : form.errors.has('price') }"
                                                   v-model="form.price"
                                                   name="price" id="price"
                                                   placeholder="តម្លៃ (រៀល)" autocomplete="price">
                                            <has-error :form="form" field="price"></has-error>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label>ប្រភេទ</label>
                                            <multiselect
                                                         v-model="selected"
                                                         :options="category"
                                                         :custom-label="CategoryLabel"
                                                         :searchable="false">
                                            </multiselect>

                                            <has-error :form="form" field="category"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="dsc">បរិយា</label>
                                        <textarea class="form-control" :class="{ 'is-invalid' : form.errors.has('dsc') }"
                                                  v-model="form.dsc"
                                                  name="dsc" id="dsc"
                                                  placeholder="បរិយា" autocomplete="dsc">
                                        </textarea>

                                        <has-error :form="form" field="dsc"></has-error>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <label for="photo" class="mb-0">រូបភាព</label>
                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool text-primary" @click="BrowseImage">
                                                            <i class="fas fa-paperclip">&nbsp;</i> ជ្រើសរូបភាព
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body text-center min--hight">
                                                    <input type="file" @change="onImageChange" name="photo" id="photo" class="d-none">
                                                    <img class="img-fluid" v-bind:src="action ? 'img/food/' + this.form.photo : this.form.photo" alt="Photo">
                                                </div>
                                            </div>
                                            <has-error :form="form" field="photo" id="vali-photo"></has-error>
                                        </div>
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
    import Select2 from "../tools/Select2";
    export default {
        components: {Select2},
        props:['category'],

        data(){
            return{
                selected:{
                    id: "",
                    name: "",
                    name_kh: ""
                },
                action:false,

                method:false,

                products: {},

                form: new Form({
                    id: "",
                    name: "",
                    name_kh: "",
                    price: "",
                    photo: "",
                    dsc: "",
                    category: "",
                    //_token: token,
                })
            }
        },
        mounted() {
            this.getProduct();

            //Save Data not need refresh page
            Fire.$on('onCreated',(page = 1) => {
                this.getProduct(page);
            });
        },
        methods:{
            newProduct(){
                this.method = false;
                this.action = false;

                this.form.reset();

                this.selected.id ="";
                this.selected.name ="";
                this.selected.name_kh ="";

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
                this.action = true;

                this.form.reset();
                this.form.fill(pro);

                let find = this.category.find(({id}) => id === pro.category);

                this.selected.id = find.id;
                this.selected.name = find.name;
                this.selected.name_kh = find.name_kh;

                $('#modal-product').modal('show');
            },
            deleteProduct(id){

            },
            editProduct(){
                this.form.category = this.selected.id;
                this.form.put('product/' +this.form.id).then(res =>{
                    Fire.$emit('onCreated',this.products.current_page);
                    $('#modal-product').modal('hide');
                }).catch(err => console.log(err));
            },
            createProduct(){
                this.form.category = this.selected.id;
                this.form.post('product').then(res =>{
                    Fire.$emit('onCreated',1);
                    $('#modal-product').modal('hide');
                    console.log(res);
                }).catch(err => console.log(err));
            },
            onImageChange(event){
                let files = event.target.files;
                if(!files.length) return;

                let reader = new FileReader()
                reader.onload = (file) =>{
                    this.form.photo = file.target.result;
                }
                reader.readAsDataURL(files[0]);
            },
            CategoryLabel({name, name_kh}){
                return `${name}-${name_kh}`
            },
            BrowseImage(){
                $('#photo').trigger('click');
            }
        }
    }
</script>

<style scoped>
    .text-font-12{
        font-size: 12px;
    }
    .text-font-14{
        font-size: 14px;
    }
    .min--hight{
        min-height: 210px;
    }
    #vali-photo{
        display: inline;
    }
</style>
