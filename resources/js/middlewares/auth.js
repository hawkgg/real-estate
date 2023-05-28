export function auth ({ next, store }){
    if(!store.state?.Main?.user){
        return next({ name: 'login' })
    }
    return next()
}
