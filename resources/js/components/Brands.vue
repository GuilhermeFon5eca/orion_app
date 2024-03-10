<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Início do card de busca -->
                <card-component title="Busca de Marcas">
                    <template v-slot:body-content>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component title="ID" id="inputID" id-help="idHelp"
                                    text-help="Opcional. Informe o ID da Marca.">
                                    <input type="number" class="form-control" id="inputID" aria-describedby="idlHelp"
                                        placeholder="ID" v-model="searchParams.id">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component title="Nome da Marca" id="inputNome" id-help="nomeHelp"
                                    text-help="Opcional. Informe o nome da marca;">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp"
                                        placeholder="Nome" v-model="searchParams.name">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer-content>
                        <button type="submit" class="btn btn-primary btn-sm float-end" @click="search()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- Fim do card de busca -->
                <!-- Início do card de listagem -->
                <card-component title="Relação de Marcas">
                    <template v-slot:body-content>
                        <table-component 
                        :datas="brands.data" 
                        :viewBtn="{visible: true, dataToggle: 'modal', dataTarget: '#viewBrandModal'}"
                        :updateBtn="{visible: true, dataToggle: 'modal', dataTarget: '#updateBrandModal'}"
                        :deleteBtn="{visible: true, dataToggle: 'modal', dataTarget: '#removeBrandModal'}"
                        :table-data="{
                            id:{title: 'ID', type: 'text'},
                            name:{title: 'Name', type: 'text'},
                            image: {title: 'Logo', type: 'image'},
                            created_at:{title: 'Data criação', type: 'data'},
                        }"></table-component>
                    </template>
                    <template v-slot:footer-content>
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <paginate-component>
      
                                    <li v-for="l, key in brands.links" :key="key" 
                                        :class="l.active?'page-item active':'page-item'" 
                                        @click="pagination(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                                data-bs-target="#brandModal">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- Fim do card de listagem -->
            </div>
        </div>
        <!-- Início Modal de inclusão de marca -->
        <modal-component id="brandModal" title="Adicionar Marca">
            <template v-slot:alerts>
                <alert-component alertType="success" :transactionDetails="transactionDetails" title="Sucesso" v-if="transactionStatus == 'success'"></alert-component>
                <alert-component alertType="danger" :transactionDetails="transactionDetails" title="Falha"  v-if="transactionStatus == 'error'"></alert-component>
            </template>
            <template v-slot:modal-body-content>
                <div class="form-group">
                    <input-container-component title="Nome da Marca" id="newName" id-help="newNameHelp" text-help="Informe o nome de uma marca">
                        <input type="text" class="form-control" id="newName" aria-describedby="newNameHelp" placeholder="Ex: Hynday" v-model="nameBrand">
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component title="Imagem" id="newImage" id-help="newImageHelp" text-help="Selecione uma imagem PNG">
                        <input type="file" class="form-control" id="newImage" aria-describedby="newImageHelp" placeholder="Selecione uma imagem" @change="loadImage($event)">
                    </input-container-component>
                </div>
            </template>
            <template v-slot:modal-footer-content>                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="save()">Salvar</button>
            </template>
        </modal-component>
        <!-- Fim Modal de inclusão de marca -->

        <!-- Início Modal de visualização de marca -->
        <modal-component id="viewBrandModal" title="Visualizar Marca">
            <template v-slot:alerts>
            </template>
            <template v-slot:modal-body-content>
                <input-container-component title="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>
                <input-container-component title="Nome">
                    <input type="text" class="form-control" :value="$store.state.item.name" disabled>
                </input-container-component>
                <input-container-component title="Logo">
                    <img :src="'storage/'+$store.state.item.image" alt="" v-if="$store.state.item.image">
                </input-container-component>
                <input-container-component title="Data de criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                </input-container-component>
            </template>
            <template v-slot:modal-footer-content>                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- Fim Modal de visualização de marca -->
        <!-- Início Modal de remoção de marca -->
        <modal-component id="removeBrandModal" title="Remover Marca">
            <template v-slot:alerts>
                <alert-component alertType="success" :transactionDetails="$store.state.transaction" title="Sucesso" v-if="this.$store.state.transaction.status == 'success'"></alert-component>
                <alert-component alertType="danger" :transactionDetails="$store.state.transaction" title="Falha"  v-if="this.$store.state.transaction.status == 'error'"></alert-component>
            </template>
            <template v-slot:modal-body-content v-if="this.$store.state.transaction.status !== 'success'">
                <input-container-component title="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>
                <input-container-component title="Nome">
                    <input type="text" class="form-control" :value="$store.state.item.name" disabled>
                </input-container-component>
            </template>
            <template v-slot:modal-footer-content>                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="remove()" v-if="this.$store.state.transaction.status !== 'success'">Remover</button>
            </template>
        </modal-component>
        <!-- Fim Modal de remoção de marca -->

        <!-- Início Modal de atualização de marca -->
        <modal-component id="updateBrandModal" title="Atualizar Marca">
            <template v-slot:alerts>
                <alert-component alertType="success" :transactionDetails="$store.state.transaction" title="Sucesso" v-if="this.$store.state.transaction.status == 'success'"></alert-component>
                <alert-component alertType="danger" :transactionDetails="$store.state.transaction" title="Falha"  v-if="this.$store.state.transaction.status == 'error'"></alert-component>
            </template>
            <template v-slot:modal-body-content>
                <div class="form-group">
                    <input-container-component title="Nome da Marca" id="updateName" id-help="updateNameHelp" text-help="Informe o nome de uma marca">
                        <input type="text" class="form-control" id="updateName" aria-describedby="updateNameHelp" placeholder="Ex: Hynday" v-model="$store.state.item.name">
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component title="Imagem" id="updateImage" id-help="updateImageHelp" text-help="Selecione uma imagem PNG">
                        <input type="file" class="form-control" id="updateImage" aria-describedby="updateImageHelp" placeholder="Selecione uma imagem" @change="loadImage($event)">
                    </input-container-component>
                </div>
            </template>
            <template v-slot:modal-footer-content>                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="update()">Atualizar</button>
            </template>
        </modal-component>
        <!-- Fim Modal de atualização de marca -->
    </div>
</template>

<script>
    export default {
        data(){
            return {
                baseUrl: 'http://127.0.0.1:8000/api/v1/brand',
                urlPagination: '',
                urlFilter: '',
                nameBrand: '',
                fileImage: [],
                transactionStatus: '',
                transactionDetails: {},
                brands: {data:[]},
                searchParams:{id: '', name: ''}
            }
        },
        methods:{
            update(){
                let formData = new FormData();
                formData.append('_method', 'patch');
                formData.append('name', this.$store.state.item.name);
                if(this.fileImage[0]){
                    formData.append('image', this.fileImage[0]);
                }

                let url = this.baseUrl + '/' + this.$store.state.item.id;

                let config  = {
                    headers:{
                        'Content-Type': 'multipart/form-data',
                    }
                }
                
                axios.post(url, formData, config)
                    .then(response =>{
                        this.$store.state.transaction.status = 'success';
                        this.$store.state.transaction.message = 'Atualizado!';
                        updateImage.value = '';
                        this.loadList();
                    })
                    .catch(errors =>{
                        this.$store.state.transaction.status = 'error';
                        this.$store.state.transaction.message = errors.response.data.message;
                        this.$store.state.transaction.errors = errors.response.data.errors;
                    })
            },
            remove(){
                let confirmation = confirm('Tem certeza que deseja remover esse registro?')
                if(!confirmation) return false;

                let url = this.baseUrl + '/' + this.$store.state.item.id;
                let formData = new FormData();
                formData.append('_method', 'delete');
                
                axios.post(url, formData)
                    .then(response =>{
                        this.$store.state.transaction.status = 'success';
                        this.$store.state.transaction.message = response.data.msg;
                        this.loadList();
                    })
                    .catch(errors =>{
                        this.$store.state.transaction.status = 'error';
                        this.$store.state.transaction.message = errors.response.data.erro;
                    })
            },
            search(){
                //console.log(this.searchParams);
                let filter = '';
                for(let key in this.searchParams){
                    if(this.searchParams[key]){
                        if(filter != ''){
                            filter += ';';
                        }
                        filter += key +':like:'+this.searchParams[key]
                    }                    
                }
                if(filter != ''){
                    this.urlPagination = 'page=1';
                    this.urlFilter = '&filter='+filter;
                }else{
                    this.urlFilter = '';
                }
                this.loadList();
            },
            pagination(l){
                if(l.url){
                    this.urlPagination = l.url.split('?')[1];
                    this.loadList();
                }
            },
            loadList(){
                let url = this.baseUrl + '?'+this.urlPagination + this.urlFilter;
                axios.get(url)
                    .then(response =>{
                        this.brands = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            },
            loadImage(e){
                this.fileImage = e.target.files;
            },
            save(){                

                let formData = new FormData();
                formData.append('name', this.nameBrand);
                formData.append('image', this.fileImage[0]);

                let config  = {
                    headers:{
                        'Content-Type': 'multipart/form-data',
                    }
                }
                axios.post(this.baseUrl, formData, config)
                    .then(response =>{
                        this.transactionStatus = 'success'
                        this.transactionDetails = {
                            message: "ID do registro: "+response.data.id 
                        }
                        this.loadList();
                    })
                    .catch(errors =>{
                        this.transactionStatus = 'error'
                        this.transactionDetails ={
                            message: errors.response.data.message,
                            errors: errors.response.data.errors,
                        }
                    })
            }
        },
        mounted(){
            this.loadList();
        }
    }
</script>