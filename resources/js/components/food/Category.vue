<template>
    <div>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">ប្រភេទមុខម្ហូបអាហារ</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/home">ទំព័រដើម</a></li>
                                <li class="breadcrumb-item active">ប្រភេទមុខម្ហូបអាហារ</li>
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
                                                @click="newCategory"
                                                class="btn btn-outline-primary btn-sm">
                                            ប្រភេទមុខម្ហូបអាហារថ្មី
                                        </button>
                                    </div>

                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-outline-primary">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>លេខ</th>
                                            <th>ប្រភេទមុខម្ហូបអាហារ</th>
                                            <th>បរិយាយ</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="cat in categories.data" :key="categories.id">
                                            <td>{{ cat.id }}</td>
                                            <td>{{ cat.name + "|" + cat.name_kh }}</td>
                                            <td>{{ cat.dsc }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" @click="infoCategory(cat)" class="btn btn-outline-primary btn-sm">កែប្រែ</button>
                                                    <button type="button" @click="deleteCategory(cat.id)" class="btn btn-outline-danger btn-sm">លុប</button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <pagination :data="categories"
                                                @pagination-change-page="getCategory"
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
    </div>
</template>

<script>
    export default {
        data(){
            return {
                categories: {},
            }
        },
        mounted() {
            this.getCategory();
        },
        methods:{
            newCategory(){

            },
            getCategory(p = 1) {
                axios.get('category/rows?page=' + p)
                    .then(res => {
                        this.categories = res.data;
                        console.log(res.data)
                    })
                    .catch(err => console.log(err));
            },
            infoCategory(category){

            },
            deleteCategory(id){

            }
        }
    }
</script>

<style scoped>
    .pagination.pagination-sm{
        margin-bottom: 0px !important;
    }
</style>
