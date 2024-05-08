import { LockClosedIcon } from "@heroicons/react/24/solid";
import { useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../axios";
import { useStateContext } from "../contexts/ContextProvider";

const Login = () => {
    const { setCurrentUser, setUserToken } = useStateContext();
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState({ __html: '' });

    const onSubmit = (ev) => {
        ev.preventDefault();
        setError({ __html: '' });

        axiosClient.post('/login', {
            email,
            password,
        })
            .then(({ data }) => {
                setCurrentUser(data.data.user);
                setUserToken(data.data.token);
            })
            .catch((error) => {
                if (error.response) {
                    const finalErrors = Object.values(error.response.data.errors).reduce((accum,
                        next) => [...accum, ...next], []);
                    setError({ __html: finalErrors.join('<br/>') });
                }
                console.log(error)
            });
    };

    return (
        <>
            <h2 className="mt-10 text-left text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Login
            </h2>

            {error.__html && (<div className="bg-red-500 rounded py-2 px-3 text-white"
                dangerouslySetInnerHTML={error}>
            </div>)}

            <form onSubmit={onSubmit} className="space-y-6" action="#" method="POST">
                <div>
                    <label
                        htmlFor="email"
                        className="sr-only"
                    >
                        Email
                    </label>
                    <div className="mt-2">
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autoComplete="email"
                            placeholder="Enter your email"
                            required
                            value={email}
                            onChange={(ev) => setEmail(ev.target.value)}
                            className="relative block w-full appearance-none rounded-md
                                        rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 
                                        placeholder-gray-500 focus:z-10 focus:border-indigo-500
                                        focus:outline-none focus:ring-indigo-500 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <div>
                    <label
                        htmlFor="password"
                        className="sr-only"
                    >
                        Password
                    </label>
                    <div className="mt-2">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autoComplete="current-password"
                            placeholder="********"
                            value={password}
                            onChange={(ev) => setPassword(ev.target.value)}
                            required
                            className="relative block w-full appearance-none rounded-md
                                                    rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 
                                                    placeholder-gray-500 focus:z-10 focus:border-indigo-500
                                                    focus:outline-none focus:ring-indigo-500 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <div className="text-sm">
                    <a
                        href="#"
                        className="font-semibold text-indigo-600 hover:text-indigo-500"
                    >
                        Forgot password?
                    </a>
                </div>

                <div>
                    <button
                        type="submit"
                        className="group relative flex w-full justify-center rounded-md 
                bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm 
                hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 
                focus-visible:outline-indigo-600"
                    >
                        <span className="absolute inset-y-0 left-0 flex items-center pl-3">
                            <LockClosedIcon
                                className="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                                aria-hidden="true"
                            />
                        </span>
                        Login
                    </button>
                </div>
            </form>

            <p className="mt-10 text-center text-sm text-gray-500">
                Not a member?{" "}
                <Link
                    to="/register"
                    className="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
                >
                    Register
                </Link>
            </p>
        </>
    );
};

export default Login;
