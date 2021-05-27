<template>
    <div class="create-blog">
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex mb-3">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                            <p class="text-primary mb-0 hover-cursor">create-blog</p>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-end flex-wrap">
                                <div class="mr-md-3 mr-xl-5">
                                    <h2>Create New Blog Post</h2>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end flex-wrap" v-if="isWritePermission">
                                <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                                    <i class="mdi mdi-plus text-muted"></i>
                                </button>
                                <button type="button" class="btn btn-primary mt-2 mt-xl-0">Add New Role</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group _input_field">
                                    <label for="exampleInputUsername1">Title</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title">
                                </div>
                                <div class="form-group blog_editor">
                                    <label>Post Description</label>
                                    <editor
                                        ref="editor"
                                        autofocus
                                        holder-id="codex-editor"
                                        save-button-id="save-button"
                                        :init-data="initData"
                                        @save="onSave"
                                        :config="config"
                                    />
                                </div>
                                <button class="btn btn-primary mr-2" @click="saveData">Save</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="space">
                                    <Upload
                                        ref="upload"
                                        type="drag"
                                        action="/api/category/upload">
                                        <div style="padding: 20px 0">
                                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                            <p>Click or drag files here to upload</p>
                                        </div>
                                    </Upload>
                                </div>
                                <div class="submit-btn text-right">
                                    <button type="submit" class="btn btn-primary mr-2">Publish</button>
                                    <button class="btn btn-light">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
        <!-- Form End-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "create-blog",
    data(){
        return {
            config: {

            },
            initData: null,
            data: {

            },
        }
    },
    methods: {
        async onSave(response) {
            console.log(response)
        },
        async saveData(){
            this.$refs.editor.save()
        },
    }
};
</script>

<style scoped>
    .create-blog {
        width: 100%;
    }
    .blog_editor {
        width: 717px;
        margin-left: 160px;
        padding: 4px 7px;
        font-size: 14px;
        border: 1px solid #dcdee2;
        border-radius: 4px;
        color: #515a6e;
        background-color: #fff;
        background-image: none;
        z-index:  -1;
    }
    .blog_editor:hover {
        border: 1px solid #57a3f3;
    }
    ._input_field{
        margin: 20px 0 20px 160px;
        width: 717px;
    }
</style>
