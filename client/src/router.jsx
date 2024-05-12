import { Navigate, createBrowserRouter } from 'react-router-dom';
import Dashboard from './views/Dashboard.jsx';
import Login from './views/Login.jsx';
import Register from './views/Register.jsx';
import GuestLayout from './components/GuestLayout.jsx';
import AuthLayout from './components/AuthLayout.jsx';
import DefaultLayout from './components/DefaultLayout.jsx';
import Post from './views/Post.jsx';
import Category from './views/Category.jsx';
import Home from './views/Home.jsx';
import About from './views/About.jsx';
import Event from './views/Event.jsx';
import SelectedEvent from './views/SelectedEvent.jsx';
import Member from './views/Member.jsx';


const router = createBrowserRouter([
    {
        path: "/",
        element: <DefaultLayout />,
        children: [
            {
                path: "/",
                element: <Navigate to="/" />,
            },
            {
                path: "/home",
                element: <Home />,
            },
            {
                path: "/about",
                element: <About />,
            },
            {
                path: "/events",
                element: <Event title="Upcoming Events" />,
            },
            // add route for past events
            {
                path: "/pastevents",
                element: <Event title="Past Events" />,
            },
            // temporary route for testing
            // should /{id}/event
            {
                path: "/selectedevent",
                element: <SelectedEvent />,
            },
            {
                path: "/members",
                element: <Member />,
            },
            {
                path: "/",
                element: <GuestLayout />,
                children: [
                    {
                        path: "/",
                        element: <Home />,
                    },
                    {
                        path: "/login",
                        element: <Login />,
                    },
                    {
                        path: "/register",
                        element: <Register />,
                    }
                ]
            },
        ]
    },
    {
        path: "/dashboard",
        element: <AuthLayout />,
        children: [
            {
                path: "/dashboard",
                element: <Navigate to="/dashboard" />,
            },
            {
                path: "/dashboard",
                element: <Dashboard />,
            },
            {
                path: "/dashboard/posts",
                element: <Post />,
            },
            {
                path: "/dashboard/categories",
                element: <Category />,
            },
        ]
    },
]);

export default router