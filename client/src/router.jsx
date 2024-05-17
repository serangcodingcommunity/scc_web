import { Navigate, createBrowserRouter } from 'react-router-dom';
import Dashboard from './views/dashboard/Dashboard.jsx';
import Login from './views/auth/Login.jsx';
import Register from './views/auth/Register.jsx';
import GuestLayout from './layouts/GuestLayout.jsx';
import AuthLayout from './layouts/AuthLayout.jsx';
import DefaultLayout from './layouts/DefaultLayout.jsx';
import Post from './views/dashboard/Post.jsx';
import Category from './views/dashboard/Category.jsx';
import Home from './views/default/home/Home.jsx';
import About from './views/default/About.jsx';
import Event from './views/default/event/Event.jsx';
import DetailEvent from './views/default/event/DetailEvent.jsx';
import Member from './views/default/Member.jsx';
import Profile from './views/default/Profile.jsx';


const router = createBrowserRouter([
    {
        path: "/",
        element: <DefaultLayout />,
        children: [
            {
                path: "/home",
                element: <Navigate to="/" />,
            },
            {
                path: "/",
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
                element: <DetailEvent />,
            },
            // {
            //     path: "/selectedpost",
            //     element: <Member />,
            // },
            {
                path: "/members",
                element: <Member />,
            },
            {
                path: "/",
                element: <GuestLayout />,
                children: [
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
            {
                path: "/dashboard/profile/:id",
                element: <Profile />,
            },
        ]
    },
]);

export default router