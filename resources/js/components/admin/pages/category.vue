<template>
    <div class="category">
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex mb-3">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                            <p class="text-primary mb-0 hover-cursor">Category</p>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-end flex-wrap">
                                <div class="mr-md-3 mr-xl-5">
                                    <h2>All Category List</h2>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end flex-wrap" v-if="isWritePermission">
                                <button type="button" @click="addModel=true" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                                    <i class="mdi mdi-plus text-muted"></i>
                                </button>
                                <button type="button" @click="addModel=true" class="btn btn-primary mt-2 mt-xl-0">Add New</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Category List</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Image</th>
                                                <th class="col-width">Category name</th>
                                                <th class="col-width">Status</th>
                                                <th class="col-width">Created At</th>
                                                <th class="col-width" v-if="isUpdatePermission || isDeletePermission">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="category in categories" :key="category.id">
                                                <td>{{ category.id }}</td>
                                                <td><img :src="`/uploads/category/${category.iconImage}`"></td>
                                                <td>{{ category.categoryName }}</td>
                                                <td><span class="badge badge-success">Publish</span></td>
                                                <td>{{ category.created_at }}</td>
                                                <td v-if="isUpdatePermission || isDeletePermission">
                                                    <Button type="dark" @click="showEditModel(category)" v-if="isUpdatePermission"><i class="mdi mdi-file-check btn-icon-append"></i> Edit</Button>
                                                    <Button type="error" @click="DeleteModel(category.id)" v-if="isDeletePermission"><i class="mdi mdi-delete-sweep btn-icon-append"></i> Remove</Button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <!--Add Model Start-->
            <Modal
                v-model="addModel"
                title="Add New Tag"
                :mask-closable="false"
                :closable="false"
                >
                <Input v-model="data.categoryName" placeholder="Enter category name..."/>
                <div class="space"><br></div>
                <div class="upload">
                    <Upload
                        ref="upload"
                        :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                        :format="['jpg','jpeg','png', 'bmp']"
                        :on-error="handleError"
                        :on-success="handleSuccess"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        type="drag"
                        action="/api/category/upload">
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                </div>
                <div class="demo-upload-list" v-if="data.iconImage">
                    <img :src="`/uploads/category/${data.iconImage}`"/>
                    <div class="demo-upload-list-cover">
                        <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                    </div>
                </div>
                <div slot="footer">
                    <Button type="primary" @click="categoryInsert">Publish</Button>
                    <Button type="default" @click="addModel=false">Close</Button>
                </div>
            </Modal>
            <!--Add Model End-->

            <!--Edit Model Start-->
            <Modal
                v-model="editModel"
                title="Edit a Tag"
                :mask-closable="false"
                :closable="false"
            >
                <Input v-model="editData.categoryName" placeholder="Enter category name..."/>
                <div class="space"><br></div>
                <div class="upload">
                    <Upload v-show="isNewAddImage"
                        ref="editDataUploads"
                        :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                        :format="['jpg','jpeg','png', 'bmp']"
                        :on-error="handleError"
                        :on-success="handleSuccess"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        type="drag"
                        action="/api/category/upload">
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                </div>
                <div class="demo-upload-list" v-if="editData.iconImage">
                    <img :src="`/uploads/category/${editData.iconImage}`"/>
                    <div class="demo-upload-list-cover">
                        <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
                    </div>
                </div>
                <div slot="footer">
                    <Button type="primary" @click="categoryUpdate(editData.id)">Update</Button>
                    <Button type="default" @click="closeEditModal">Close</Button>
                </div>
            </Modal>
            <!--Edit Model End-->

            <!--Delete Model-->
            <Modal v-model="showDeleteModel" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
                <div style="text-align:center">
                    <p>Are you sure want to delete category?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long :loading="modal_loading" @click="DeleteCategory">Delete</Button>
                </div>
            </Modal>
            <!--End Delete Model-->

        </div>
    </div>
</template>

<script>
export default {
    name: "category",
    data() {
        return {
            data: {
                categoryName: '',
                iconImage: ''
            },
            addModel: false,
            editModel: false,
            categories: [],
            editData: {
                categoryName: '',
                iconImage: ''
            },
            deleteItem: {},
            showDeleteModel: false,
            modal_loading: false,
            token: '',
            isNewAddImage: false,
            isEditingItem: false
        }
    },
    async created() {
        this.token = window.Laravel.csrfToken
        this.AllCategories()
    },
    methods: {
        //Tag Show Function
        async AllCategories() {
            const res = await this.callApi('get', '/api/category');
            if (res.status == 200) {
                this.categories = res.data
            } else {
                this.er()
            }
        },
        //Tag Insert Function
        async categoryInsert() {
            if (this.data.categoryName.trim() == '')return this.w('Category name is required!')
            if (this.data.iconImage.trim() == '')return this.w('Category image is required!')
            const res = await this.callApi('post', '/api/category',this.data);
            if (res.status == 200) {
                this.AllCategories()
                this.s('Category has been added successfully!')
                this.addModel = false
                this.data.categoryName = ''
                this.data.iconImage = ''
            } else {
                this.er()
            }
        },
        //Tag Edit Function
        async showEditModel(category) {
            // let obj = {
            //     id: category.id,
            //     categoryName: category.categoryName,
            //     iconImage: category.iconImage
            // }
            this.editData = category
            this.editModel = true
            this.isEditingItem = true
        },
        closeEditModal() {
            this.isEditingItem = false;
            this.editModel = false;
        },
        //Tag Update Function
        async categoryUpdate(id) {
            if (this.editData.categoryName.trim() == '')return this.w('Category name is required!')
            if (this.editData.iconImage.trim() == '')return this.w('Category image is required!')
            const res = await this.callApi('patch', '/api/category/'+id, this.editData);
            if (res.status == 200) {
                this.AllCategories()
                this.s('Category has been successfully updated!')
                this.editModel = false
            } else {
                this.er()
            }
        },
        //Show Delete Model Function
        DeleteModel(id) {
            this.showDeleteModel = true
            this.deleteItem = id
        },
        //Delete Tag Function
        async DeleteCategory() {
            this.modal_loading = true;
            setTimeout(() => {
                const res = this.callApi('delete', '/api/category/'+this.deleteItem);
                this.showDeleteModel = false
                this.s('Category has been successfully deleted!')
                this.AllCategories()
            }, 2000);
        },

        //Image Upload & Validation All Functions
        handleSuccess (res, file) {
            if (this.isEditingItem) {
                return this.editData.iconImage = res
            }
            this.data.iconImage = res
        },
        handleFormatError (file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleError (file) {
            this.$Notice.warning({
                title: 'Opps! Something went wrong?',
                desc: 'Please Try Again'
            });
        },
        handleMaxSize (file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },
        //Delete Image
        async deleteImage(isAdd=true) {
            let image;
            if (!isAdd) {
                this.isNewAddImage = true
                image = this.editData.iconImage;
                this.editData.iconImage = "";
                this.$refs.editDataUploads.clearFiles();
            } else {
                image = this.data.iconImage
                this.data.iconImage = ''
                this.$refs.upload.clearFiles()
            }

            const res = await this.callApi('post', '/api/category/image/delete', {imageName: image});
            if (res.status != 200) {
                this.data.iconImage = image;
                this.er()
            } else {
                this.s('Category image has been successfully removed!')
            }
        },

    }

}
</script>

<style scoped>
    .category {
        width: 100%;
    }
    .col-width {
        width: 25%;
    }
    .image_thumb img {
        width: 100%;
    }
    .table td img {
        width: 50px;
        height: 50px;
        border-radius: 100%;
    }
    /*Image Upload div*/
    .demo-upload-list{
        display: inline-block;
        width: 100%;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 35%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #ffffff;
        font-size: 35px;
        cursor: pointer;
        margin: 50px 2px;
        background: red;
        padding: 7px 15px 7px 15px;
        border-radius: 10px;
    }
</style>
