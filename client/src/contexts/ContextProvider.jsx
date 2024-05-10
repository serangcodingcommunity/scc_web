import { useState, createContext, useContext, useEffect } from 'react'

const StateContext = createContext({
    user: null,
    token: null,
    setUser: () => { },
    setToken: () => { },
})

export const ContextProvider = ({ children }) => {
    const [user, setUser] = useState({});
    const [token, _setToken] = useState(localStorage.getItem('token') || '');

    // useEffect(() => {
    //     const storedUser = localStorage.getItem('currentUser');
    //     if (storedUser) {
    //         setCurrentUserState(JSON.parse(storedUser));
    //     }
    // }, []);

    // const setCurrentUser = (user) => {
    //     setCurrentUserState(user);
    //     localStorage.setItem('currentUser', JSON.stringify(user));
    // };

    const setToken = (token) => {
        if(token) { 
            localStorage.setItem('token', token);
        } else {
            localStorage.removeItem('token');
        }
        _setToken(token);
    }
    
    return (
        <StateContext.Provider value={{
            user, 
            setUser, 
            token, 
            setToken, 
        }}
    >
        {children}
    </StateContext.Provider>
    )
}

export const useStateContext = () => useContext(StateContext)