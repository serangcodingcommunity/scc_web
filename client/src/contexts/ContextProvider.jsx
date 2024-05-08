import { useState, createContext, useContext } from 'react'

const StateContext = createContext({
    currentUser: {},
    userToken: null,
    setCurrentUser: () => { },
    setUserToken: () => { },
})

const tmpCategories = [
    {
        id: 1,
        title: 'Category 1',
        slug: 'category-1',
    },
    {
        id: 2,
        title: 'Category 2',
        slug: 'category-2',
    },
]

export const ContextProvider = ({ children }) => {
    const [currentUser, setCurrentUser] = useState({});
    const [userToken, _setUserToken] = useState(localStorage.getItem('token') || '');
    const [categories, setCategories] = useState(tmpCategories);

    const setUserToken = (token) => {
        if(token) { 
            localStorage.setItem('token', token);
        } else {
            localStorage.removeItem('token');
        }
        _setUserToken(token);
    }
    
    return (
        <StateContext.Provider 
        value={{
            currentUser, 
            setCurrentUser, 
            userToken, 
            setUserToken, 
            categories,
        }}
    >
        {children}
    </StateContext.Provider>
    )
}

export const useStateContext = () => useContext(StateContext)