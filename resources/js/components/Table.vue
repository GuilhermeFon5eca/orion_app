<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr >
                    <th v-for="t, key in tableData" :key="key" scope="col" >{{ t.title }}</th>
                    <th v-if="viewBtn.visible || updateBtn.visible || deleteBtn.visible"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, key in filterDatas" :key="key">
                    <td v-for="value, valueKey in obj" :key="valueKey">
                        <span v-if="tableData[valueKey].type == 'text'">{{ value }}</span>
                        <span v-if="tableData[valueKey].type == 'data'">
                            {{  $filters.formatDateTime(value) }}
                        </span>
                        <span v-if="tableData[valueKey].type == 'image'">
                            <img :src="'/storage/'+value" width="40"  height="40">
                        </span>
                    </td>
                    <td v-if="viewBtn.visible || updateBtn.visible || deleteBtn.visible">
                        <button v-if="viewBtn.visible"  class="btn btn-outline-primary btn-sm" :data-bs-toggle="viewBtn.dataToggle" @click="setStore(obj)" :data-bs-target="viewBtn.dataTarget">Visualizar</button>
                        <button v-if="updateBtn.visible"  class="btn btn-outline-primary btn-sm" :data-bs-toggle="updateBtn.dataToggle" @click="setStore(obj)" :data-bs-target="updateBtn.dataTarget">Atualizar</button>
                        <button v-if="deleteBtn.visible"  class="btn btn-outline-danger btn-sm" :data-bs-toggle="deleteBtn.dataToggle" @click="setStore(obj)" :data-bs-target="deleteBtn.dataTarget">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['datas', 'tableData', 'viewBtn', 'updateBtn','deleteBtn'],
    methods:{
        setStore(obj){
            this.$store.state.transaction.status = '';
            this.$store.state.transaction.message = '';
            this.$store.state.transaction.data = '';
            this.$store.state.item = obj;
        }
    },
    computed:{
        filterDatas(){
            let fields = Object.keys(this.tableData);
            let filteredDatas = [];

            this.datas.map((item, key) =>{
                let filteredItem = {};
                fields.forEach(field =>{
                    filteredItem[field] = item[field]                    
                })
                filteredDatas.push(filteredItem);
            });

            return filteredDatas
        }
    }

}
</script>
