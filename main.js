const app = Vue.createApp({
    data() {
        return {
            columns: [
                { name: 'title', required: true, label: 'Title', align: 'left', field: row => row.name, format: val => `${val}`, sortable: true },
                { name: 'date', align: 'left', label: 'Begin date', field: 'date', sortable: true },
                { name: 'responsible', label: 'Responsible', field: 'responsible', sortable: true },
                { name: 'amount', label: 'Amount', field: 'amount', sortable: true },
            ],
            rows: [],
            dateStart: '',
            dateEnd: '',
            userSelect: 0,
            userList: []
        }
    },
    methods: {
        loadTable(){
            const post = {
                event: 'print-table'
            }
            const headers = {
                'Content-Type': 'application/x-www-form-urlencoded'
            };

            axios.post('function.php', post, { headers })
                .then(response => {
                    this.rows = []
                    let resultJson = response.data
                    this.rows.push(...resultJson)
                });
        },
        users(){
            const post = {
                event: 'user-list'
            }
            const headers = {
                'Content-Type': 'application/x-www-form-urlencoded'
            };

            axios.post('function.php', post, { headers })
                .then(response => {
                    this.userList = []
                    let resultJson = response.data
                    this.userList.push(...resultJson)
                });
        },
        search(){
            const post = {
                event: 'filter-table',
                dateStart: this.dateStart,
                dateEnd: this.dateEnd,
                userSelect: this.userSelect
            }
            const headers = {
                'Content-Type': 'application/x-www-form-urlencoded'
            };

            axios.post('function.php', post, { headers })
                .then(response => {
                    this.rows = []
                    let resultJson = response.data
                    this.rows.push(...resultJson)
                });
        }
    },
    mounted(){
        this.loadTable()
        this.users()
    }
})

app.use(Quasar, { config: {} })
app.mount('#q-app')