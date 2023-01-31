<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@^1.0.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/quasar@2.7.5/dist/quasar.prod.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="main.css">
</head>

<body>
<div id="q-app">
    <div class="q-pa-md">
        <div class="filter-block">
            <div>
                <lable class="form-label">Begin date</lable>
                <div class="date-block">
                    <input type="date" class="form-control" v-model="dateStart">
                    <span>-</span>
                    <input type="date" class="form-control" v-model="dateEnd">
                </div>
            </div>
            <div>
                <lable class="form-label">Responsible</lable>
                <select v-model="userSelect">
                    <option selected value="0">no select</option>
                    <option v-for="user in userList" :value="user.id">{{user.name}}</option>
                </select>
            </div>
            <button class="btn-search" @click="search">Search</button>
        </div>
    </div>
    <div class="q-pa-md">
        <q-table title="Deal list" :rows="rows" :columns="columns" row-key="name"></q-table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quasar@2.7.5/dist/quasar.umd.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="main.js"></script>
</body>

</html>