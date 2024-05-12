import { useEffect, useState } from "react";
import { Link, useNavigate  } from "react-router-dom";
import axiosClient from "../../axios";
import { useStateContext } from "../../contexts/ContextProvider";
import { FaGithub, FaGoogle } from "react-icons/fa";

const Login = () => {
    const [input, setInput] = useState({
        email: '',
        password: ''
    });
    const [loginGoogleUrl, setLoginGoogleUrl] = useState(null);
    const [loginGithubUrl, setLoginGithubUrl] = useState(null);
    const [isLoading, setIsLoading] = useState(false);
    const [errors, setErrors] = useState([]);
    const navigate = useNavigate();

    const handleInput = (e) => {
        setInput(prevState => ({
            ...prevState,
            [e.target.id]: e.target.value
        }))
    }

    const handleLogin = (e) => {
        e.preventDefault();
        setIsLoading(true)
        axiosClient.post('/login',  input)
            .then(res => {
                localStorage.setItem('token', res.data.data.token)
                setIsLoading(false)
                window.location.href = '/dashboard'
            }).catch(errors => {
                setIsLoading(false)
                if (errors.response.status == 422) {
                    setErrors(errors.response.data.data.errors)
                }
            })
    }

    useEffect(() => {
        axiosClient.get('/google/redirect')
            .then((res) => {
                setLoginGoogleUrl(res.data.url)
            })
            .catch(error => {
                console.error("Error fetching Google login URL:", error);
            });
    }, []);

    useEffect(() => {
        axiosClient.get('/github/redirect')
            .then((res) => {
                setLoginGithubUrl(res.data.url)
            })
            .catch(error => {
                console.error("Error fetching Github login URL:", error);
            });
    }, []);

    return (
        <>
            <div className="mt-20 sm:mx-auto sm:w-full sm:max-w-sm rounded-lg p-5 shadow-xl border-2 border-slate-50 relative bg-white">
                <span className="absolute top-0 left-1/2 transform -translate-x-1/2 w-1/4 h-4 rounded-md bg-[#142D55]"></span>

                <div className="flex items-center mt-5">
                    <h2 className="text-left text-xl leading-9 tracking-tight text-gray-900 mr-1">
                        Login
                    </h2>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        strokeWidth={1.5}
                        stroke="currentColor"
                        className="w-5 h-5"
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"
                        />
                    </svg>
                </div>

                <span className="text-xs font-semibold">
                    Selamat datang, masuk akun untuk melanjutkan
                </span>

                <p>{errors.email && <span className="text-red-500 text-xs">{errors.email}</span>}</p>

                <form
                    onSubmit={handleLogin}
                    className="space-y-2"
                    action="#"
                    method="POST"
                >
                    <div className="space-y-5 mx-8">
                        <label htmlFor="email" className="sr-only"></label>
                        <div className="mt-2">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autoComplete="email"
                                placeholder="example@email.com"
                                required
                                value={input.email}
                                onChange={handleInput}
                                className="relative block w-full appearance-none rounded-md
                                        rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 
                                        placeholder-gray-500 focus:z-10 focus:border-[#142D55]
                                        focus:outline-none focus:ring-[#142D55] sm:text-sm sm:leading-6"
                            />
                        </div>
                    </div>

                    <div className="mx-8">
                        <label htmlFor="password" className="sr-only">
                            Password
                        </label>
                        <div className="mt-2">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autoComplete="current-password"
                                placeholder="********"
                                value={input.password}
                                onChange={handleInput}
                                required
                                className="relative block w-full appearance-none rounded-md
                                                    rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 
                                                    placeholder-gray-500 focus:z-10 focus:border-[#142D55]
                                                    focus:outline-none focus:ring-[#142D55] sm:text-sm sm:leading-6"
                            />
                        </div>
                    </div>

                    <div className="flex items-center justify-between mx-8">
                        <Link
                            to="/register"
                            className="text-xs font-normal hover:font-medium leading-6 text-[#142D55]"
                        >
                            Register
                        </Link>

                        <div className="text-xs">
                            <a
                                href="#"
                                className="font-medium text-[#142D55] hover:font-semibold"
                            >
                                Lupa Password ?
                            </a>
                        </div>
                    </div>

                    <div className="flex justify-end mr-8">

                    {isLoading &&
                        <button
                            type="submit"
                            className="group relative flex justify-center rounded-xl bg-[#142D55] px-4 text-xs leading-6 text-white shadow-xl focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#142D55] hover:scale-110"
                        >
                            <svg aria-hidden="true" role="status" className="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
                            </svg>
                        </button>
                    }
                    {!isLoading &&
                        <button
                            type="submit"
                            className="group relative flex justify-center rounded-xl bg-[#142D55] px-4 text-xs leading-6 text-white shadow-xl focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#142D55] hover:scale-110"
                        >
                            Login
                        </button>
                    }
                    </div>
                </form>

                <p className="mt-2 text-center text-xs text-gray-500">
                    <span className="font-bold text-xl text-center">_</span> Or Login With{" "}
                    <span className="font-bold text-xl text-center">_</span>
                </p>

                <div className="flex justify-center space-x-4 mt-2">
                    <button onClick={() => window.location.href = loginGoogleUrl} className="bg-white text-black border border-black rounded-lg flex items-center text-xs p-1 hover:scale-110">
                        <FaGoogle className="h-3 w-3 mr-2" />
                        Google
                    </button>
                    <button onClick={() => window.location.href = loginGithubUrl} className="bg-white text-black border border-black rounded-lg flex items-center text-xs p-1 hover:scale-110">
                        <FaGithub className="h-3 w-3 mr-2" />
                        GitHub
                    </button>
                </div>
            </div>
        </>
    );
};

export default Login;
