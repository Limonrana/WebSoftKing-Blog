import { mapGetters } from 'vuex'
export default {
    data() {
        return {

        }
    },
    methods: {
        async callApi(method, url, dataobj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataobj
                });
            }
            catch (e) {
                return e.response;
            }
        },

        //iView UI Alert
        i(desc, title="Hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s(desc, title="Great") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w(desc, title="Opps!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e(desc, title="Hey") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        er(desc="Something Went Wrong! Please Try Again.", title="Opps!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        checkUserPermission(key) {
            if (!this.userPermission) return true
            let isPermitted = false;
            for (let d of this.userPermission) {
                if (this.$route.name == d.name) {
                    if (d[key]) {
                        isPermitted = true
                        break
                    }
                    else {
                        break
                    }
                }
            }
            return isPermitted
        }
    },
    computed: {
        ...mapGetters({
            'userPermission' : 'getUserPermission'
        }),
        isReadPermission() {
            return this.checkUserPermission('read')
        },
        isWritePermission() {
            return this.checkUserPermission('write')
        },
        isUpdatePermission() {
            return this.checkUserPermission('update')
        },
        isDeletePermission() {
            return this.checkUserPermission('delete')
        },
    }
}
