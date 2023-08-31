import { defineStore, StateTree } from "pinia";
import {Author, Book} from "../types.ts";

const urlApiBase = import.meta.env.VITE_API_BASE;
export const useAuthorStore = defineStore('authorStore', {
    state: (): StateTree => {
      return {
          authors: [] as Array<Author>,
          books: [] as Array<Book>
      }
    },

    getters: {
        getAuthors: state => state.authors,
        getBooks: state => state.books
    },

    actions: {
        fetchAuthors() {
            return fetch(`${urlApiBase}/author/list`, {
                method: 'GET',
                headers: {'Content-Type': 'application/json'}
            }).then(res => res.json())
                .then(authors => {
                    this.$state.authors = authors
                })
                .catch(err => {
                    console.log('err: ', err)
                    throw err
                })
        },

        fetchBooks() {
            return fetch(`${urlApiBase}/book/list`, {
                method: 'GET',
                headers: {'Content-Type': 'application/json'}
            }).then(res => res.json())
                .then(books => {
                    this.$state.books = books
                })
                .catch(err => {
                    console.log('err: ', err)
                    throw err
                })
        },

        fetchBooksFromAuthor(authorId: string) {
            return fetch(`${urlApiBase}/author/${authorId}/books`, {
                method: 'GET',
                headers: {'Content-Type': 'application/json'}
            }).then(res => res.json())
                .then(books => {
                    console.log('books store: ', books)
                    this.$state.books = books
                })
                .catch(err => {
                    console.log('err: ', err)
                    throw err
                })
        },

        searchAuthor(query: string = '') {
            if (!query) return Promise.resolve([])

            return fetch(`${urlApiBase}/author/search/${query}`, {
                method: 'GET',
                headers: {'Content-Type': 'application/json'}
            }).then(res => res.json())
                .then(authors => {
                    return authors
                })
                .catch(err => {
                    console.log('err: ', err)
                    throw err
                })
        },

        registerAuthor(author: Author) {
            return fetch(`${urlApiBase}/author/create`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(author)
            }).then(res => res.json())
                .then(author => {
                    return author
                })
                .catch(err => {
                    console.log('err: ', err)
                    throw err
                })
        },

        registerBook(book: Book) {
            return fetch(`${urlApiBase}/book/create`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(book)
            }).then(res => res.json())
                .then(book => {
                    return book
                })
                .catch(err => {
                    console.log('err: ', err)
                    throw err
                })
        },

        deleteBook(bookId: string) {
            return fetch(`${urlApiBase}/book/delete/${bookId}`, {
                method: 'DELETE',
                headers: {'Content-Type': 'application/json'},
            }).then(res => res.json())
                .then(bookDelete => {
                    this.$state.books = this.$state.books.filter((book: Book) => book.id !== bookDelete.id)
                    return bookDelete
                })
                .catch(err => {
                    console.log('err: ', err)
                    throw err
                })
        }
    }
})
