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
    const [darkMode, setDarkMode] = useState(false);

    const setToken = (token) => {
        if(token) { 
            localStorage.setItem('token', token);
        } else {
            localStorage.removeItem('token');
        }
        _setToken(token);
    }

    const toggleDarkMode = () => {
        setDarkMode(!darkMode);
        if (!darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    };
    
    return (
        <StateContext.Provider value={{
            user, 
            setUser, 
            token, 
            setToken, 
            darkMode,
            toggleDarkMode 
        }}
    >
        {children}
    </StateContext.Provider>
    )
}

export const useStateContext = () => useContext(StateContext)