import {createRouter, createWebHistory, Router, RouteRecordRaw} from "vue-router";
import AuthorRegistration from "../views/AuthorRegistration.vue";
import BooksRegistration from "../views/BooksRegistration.vue";
import ListAuthors from "../views/ListAuthors.vue";
import ListBooks from "../views/ListBooks.vue";
import Home from "../views/Home.vue";


const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/author-registration',
        name: 'AutorRegistration',
        component: AuthorRegistration
    },
    {
        path: '/book-registration',
        name: 'BookRegistration',
        component: BooksRegistration
    },
    {
        path: '/list-authors',
        name: 'ListAuthor',
        component: ListAuthors
    },
    {
        path: '/list-books',
        name: 'ListBooks',
        component: ListBooks
    }
]

const index: Router = createRouter({
    history: createWebHistory(),
    routes
})

export default index
