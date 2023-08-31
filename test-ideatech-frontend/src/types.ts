
export type Author = {
    id: string,
    firstName: string,
    lastName: string,
    country: string,
    birthday: Date,
    biography: string
}

export type Book = {
    id: string,
    title: string,
    gender: string,
    cover: string,
    publicationYear: Date,
    synopsis: string,
    author_id: string,
    author: Author | null
}
