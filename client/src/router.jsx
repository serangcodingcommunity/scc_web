import { Navigate, createBrowserRouter } from 'react-router-dom';
import App from './App.jsx';
import Dashboard from './views/Dashboard.jsx';
import Login from './views/Login.jsx';
import Register from './views/Register.jsx';
import GuestLayout from './components/GuestLayout.jsx';
import DefaultLayout from './components/DefaultLayout.jsx';
import Post from './views/Post.jsx';


const router = createBrowserRouter([
    {
        path: "/admin",
        element: <DefaultLayout />,
        children: [
            {
                path: "admin/dashboard",
                element: <Navigate to="/" />,
            },
            {
                path: "/admin",
                element: <Dashboard />,
            },
            {
                path: "/admin/posts",
                element: <Post />,
            },
        ]
    },
    {
        path: "/",
        element: <GuestLayout />,
        children: [
            {
                path: "/Login",
                element: <Login />,
            },
            {
                path: "/Register",
                element: <Register />,
            },
        ]
    }
]);

export default router