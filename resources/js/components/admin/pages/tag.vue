<template>
    <div class="tag">
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex mb-3">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                            <p class="text-primary mb-0 hover-cursor">Tags</p>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-end flex-wrap">
                                <div class="mr-md-3 mr-xl-5">
                                    <h2>All Tags List</h2>
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
                                    <h4 class="card-title">Tag List</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" v-if="isReadPermission">
                                            <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th class="col-width">Tag name</th>
                                                <th class="col-width">Status</th>
                                                <th class="col-width">Created At</th>
                                                <th class="col-width" v-if="isUpdatePermission || isDeletePermission">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="tag in tags" :key="tag.id">
                                                <td>{{ tag.id }}</td>
                                                <td>{{ tag.tagName }}</td>
                                                <td><span class="badge badge-success">Publish</span></td>
                                                <td>{{ tag.created_at }}</td>
                                                <td v-if="isUpdatePermission || isDeletePermission">
                                                    <Button type="dark" @click="showEditModel(tag)" v-if="isUpdatePermission"><i class="mdi mdi-file-check btn-icon-append"></i> Edit</Button>
                                                    <Button type="error" @click="DeleteModel(tag.id)" v-if="isDeletePermission"><i class="mdi mdi-delete-sweep btn-icon-append"></i> Remove</Button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="not-permitted" v-else>
                                            <h3>You don't have permission to read data.</h3>
                                        </div>
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
                <Input v-model="data.tagName" placeholder="Enter tag name..."/>
                <div slot="footer">
                    <Button type="primary" @click="tagInsert">Publish</Button>
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
                <Input v-model="editData.tagName" placeholder="Enter tag name..."/>
                <div slot="footer">
                    <Button type="primary" @click="tagUpdate(editData.id)">Publish</Button>
                    <Button type="default" @click="editModel=false">Close</Button>
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
                    <p>Are you sure want to delete tag?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long :loading="modal_loading" @click="DeleteTag">Delete</Button>
                </div>
            </Modal>
            <!--End Delete Model-->

        </div>
    </div>
</template>

<script>
export default {
    name: "tag",
    data() {
        return {
            data: {
                tagName: ''
            },
            addModel: false,
            editModel: false,
            tags: [],
            editData: {
                tagName: ''
            },
            deleteItem: {},
            showDeleteModel: false,
            modal_loading: false
        }
    },
    async created() {
            this.AllTags()
    },
    methods: {
        //Tag Show Function
        async AllTags() {
            const res = await this.callApi('get', '/api/tag');
            if (res.status == 200) {
                this.tags = res.data
            } else {
                this.er()
            }
        },
        //Tag Insert Function
        async tagInsert() {
            if (this.data.tagName.trim() == '')return this.w('Tag name is required!')
            const res = await this.callApi('post', '/api/tag',this.data);
            if (res.status == 200) {
                this.AllTags()
                this.s('Tag has been added successfully!')
                this.addModel = false
                this.data.tagName = ''
            } else {
                this.er()
            }
        },
        //Tag Edit Function
        async showEditModel(tag) {
            let obj = {
                id: tag.id,
                tagName: tag.tagName
            }
            this.editData = obj
            this.editModel=true
        },
        //Tag Update Function
        async tagUpdate(id) {
            if (this.editData.tagName.trim() == '')return this.w('Tag name is required!')
            const res = await this.callApi('patch', '/api/tag/'+id, this.editData);
            if (res.status == 200) {
                this.AllTags()
                this.s('Tag has been successfully updated!')
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
        async DeleteTag() {
            this.modal_loading = true;
            setTimeout(() => {
                const res = this.callApi('delete', '/api/tag/'+this.deleteItem);
                this.showDeleteModel = false
                this.s('Tag has been successfully deleted!')
                this.AllTags()
            }, 2000);
        }

    }

}
</script>

<style scoped>
    .tag {
        width: 100%;
    }
    .col-width {
        width: 25%;
    }
</style>
