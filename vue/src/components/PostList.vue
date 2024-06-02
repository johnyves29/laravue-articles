<template>
    <div class="bg-white py-0 sm:py-0">
        <div class="max-w-md mx-auto mt-5 px-4" id="targetDiv">
            <form @submit.prevent="addArticle">
                <div class="mb-4">
                    <label
                        for="title"
                        class="block text-gray-700 text-sm font-bold mb-2"
                        >Title:</label
                    >
                    <input
                        type="text"
                        id="title"
                        v-model="article.title"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="content"
                        class="block text-gray-700 text-sm font-bold mb-2"
                        >Content:</label
                    >
                    <textarea
                        id="content"
                        v-model="article.content"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        rows="5"
                    ></textarea>
                </div>
                <div class="flex items-center justify-between">
                    <button
                        type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    >
                        Save
                    </button>
                </div>
            </form>
            <!-- <button @click="clearForm()" class="btn btn-danger btn-block">
                Cancel
            </button> -->
        </div>
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div
                class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:my-12 sm:py-12 lg:mx-0 lg:max-w-none lg:grid-cols-3"
            >
                <article
                    v-for="article in articles"
                    :key="article.id"
                    class="flex max-w-xl flex-col items-start justify-between sm:mx-auto"
                >
                    <img
                        class="w-full"
                        src="https://placehold.co/600x400"
                        alt="Blog image"
                    />
                    <div class="group relative">
                        <h3
                            class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600"
                        >
                            <a href="#">
                                <span class="absolute inset-0" />
                                {{ article.title }}
                            </a>
                        </h3>
                        <p
                            class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600"
                        >
                            {{ article.content }}
                        </p>
                    </div>
                    <hr />
                    <!-- <button
                        @click="editArticle(article)"
                        class="btn btn-warning mb-2"
                    >
                        Edit
                    </button>
                    <button
                        @click="deleteArticle(article.id)"
                        class="btn btn-danger"
                    >
                        Delete
                    </button> -->
                    <div class="flex space-x-2 mt-5">
                        <!-- Edit Button -->
                        <button
                            @click="editArticle(article)"
                            class="flex items-center bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Edit
                        </button>
                        <!-- Delete Button -->
                        <button
                            @click="deleteArticle(article.id)"
                            class="flex items-center bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Delete
                        </button>
                    </div>
                </article>
            </div>
            <nav class="mt-5" aria-label="Page navigation example">
                <ul
                    class="pagination flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
                >
                    <li
                        v-bind:class="[{ disabled: !pagination.prev_page_url }]"
                        class="page-item"
                    >
                        <a
                            class="page-link relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                            href="#"
                            @click="fetchArticles(pagination.prev_page_url)"
                            >Previous</a
                        >
                    </li>

                    <li class="page-item disabled text-sm text-gray-700">
                        <a class="page-link font-medium" href="#"
                            >Page {{ pagination.current_page }} of
                            {{ pagination.last_page }}</a
                        >
                    </li>

                    <li
                        v-bind:class="[{ disabled: !pagination.next_page_url }]"
                        class="page-item"
                    >
                        <a
                            class="page-link relative inline-flex items-center rounded-r-md px-5 py-2 text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                            href="#"
                            @click="fetchArticles(pagination.next_page_url)"
                            >Next</a
                        >
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            articles: [],
            article: {
                id: '',
                title: '',
                content: ''
            },
            article_id: '',
            pagination: {},
            edit: false
        }
    },

    created () {
        this.fetchArticles()
    },

    methods: {
        fetchArticles (page_url) {
            let vm = this
            page_url =
                page_url || `${import.meta.env.VITE_API_BASE_URL}/api/articles`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.articles = res.data
                    vm.makePagination(res.meta, res.links)
                })
                .catch(err => console.log(err))
        },
        makePagination (meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }

            this.pagination = pagination
        },
        deleteArticle (id) {
            if (confirm('Are You Sure?')) {
                fetch(
                    `${import.meta.env.VITE_API_BASE_URL}/api/article/${id}`,
                    {
                        method: 'delete'
                    }
                )
                    .then(res => res.json())
                    .then(data => {
                        alert('Article Removed')
                        this.fetchArticles()
                    })
                    .catch(err => console.log(err))
            }
        },
        addArticle () {
            if (this.edit === false) {
                // Add
                fetch(`${import.meta.env.VITE_API_BASE_URL}/api/article`, {
                    method: 'post',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm()
                        alert('Article Added')
                        this.fetchArticles()
                    })
                    .catch(err => console.log(err))
            } else {
                // Update
                fetch(`${import.meta.env.VITE_API_BASE_URL}/api/article`, {
                    method: 'put',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm()
                        alert('Article Updated')
                        this.fetchArticles()
                    })
                    .catch(err => console.log(err))
            }
        },
        editArticle (article) {
            this.scrollToSection('targetDiv')
            this.edit = true
            this.article.id = article.id
            this.article.article_id = article.id
            this.article.title = article.title
            this.article.content = article.content
        },
        clearForm () {
            this.edit = false
            this.article.id = null
            this.article.article_id = null
            this.article.title = ''
            this.article.content = ''
        },
        scrollToSection (id) {
            const element = document.getElementById(id)
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' })
            }
        }
    }
}
</script>
