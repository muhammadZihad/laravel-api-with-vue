<template>
    <div>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    Input Box
                </div>
                <div class="card-body">
                <form @submit.prevent="addArticle()" class="mb-3">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Title" v:model="article.title">
                </div>
                <div class="form-group">
                    <textarea type="text" class="form-control" placeholder="Content" v:model="article.titbodyle">
                    </textarea>
                </div>
                <button class="btn btn-success btn-block">Save</button>
            </form>
                </div>
            </div>
            


        <h1>Articles</h1>

        <div class="accordion" id="accordionExample">
            <div v-for="art in articles" v-bind:key="art.id" class="card mb-3">
                <div class="card-header" v-bind:id=" 'heading'+art.id">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" >
                    {{ art.title }}
                    </button>
                </h2>
                </div>
                <div class="card-body">
                   <p>
                       {{  art.body }}
                   </p>
                </div>
                    <div class="card-footer">
                            <button @click="deleteArticle(art.id)" class="btn btn-sm btn-danger">Delete</button>
                    </div>
                </div>
            </div>

                            <div class="card-footer text-center">
                    <a @click=" fetchArticles(pagination.next) " href="#">Load more...</a>
                </div>
        </div>
        </div>
    
</template>


<script>
export default {
    data(){
        return{
            articles:[],
            article: {
                id:'',
                title:'',
                body:''
            },
            id:'',
            pagination:{},
            edit:false
        }
    },
    created(){
        this.fetchArticles();
    },
    methods:{
        fetchArticles(page_url){
            let vm = this;
            let page = page_url || 'api/articles';
            axios.get(page)
            .then(res=>{
                if(Object.keys(this.articles).length  === 0 || page_url ===undefined){  
                    this.articles = res.data.data;
                }
                else{
                    res.data.forEach(element => {
                        this.articles.push(element);
                    });
                }
                //vm.paginateArticle(res.meta,res.links);
            })
        },
        paginateArticle(meta,links){
            let pagination = {
                next:links.next,
                last:links.last
            }
            this.pagination = pagination;
        },
        deleteArticle(id){
            if(confirm("Are you sure ?")){
                axios.delete('api/article/'+id)
                .then(res=>{
                    alert('Article removed');
                    this.fetchArticles();
                })
                .catch(err => console.log(err));
            }
        },
        addArticle(){
            if(this.edit){

            }else{
                axios.post('api/article',{
                    title:this.article.title,
                    body:this.article.body
                    },
                    {
                        headers: {
                        'Content-type': 'application/x-www-form-urlencoded',
                        }
                    })
                .then(res =>{
                    this.article.title = '';
                    this.article.body = '';
                    alert('article added');
                    this.fetchArticles();
                })
            }
        }
    }

}
</script>