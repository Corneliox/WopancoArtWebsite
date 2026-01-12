<div
    class="auth-card
           w-full
           sm:max-w-md
           mt-6
           px-8
           py-6
           bg-white
           rounded-2xl
           border
           border-gray-200
           ring-1
           ring-gray-300/50
           shadow-xl
           overflow-hidden
           transition
           duration-300
           hover:shadow-2xl"
>

    <div class="mb-5 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Login</h2>
        <p class="text-sm text-gray-600">Welcome back! Please login to continue.</p>
    </div>

    <form method="POST" action="https://wopancoart.com/login">
        <input type="hidden" name="_token" value="NaCOe7uOOFytCyYGFZe37oy7wCy98ZV5Pyyf4ENT" autocomplete="off">

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="email">
                Email
            </label>
            <input
                id="email"
                type="email"
                name="email"
                required
                autofocus
                autocomplete="username"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="password">
                Password
            </label>

            <div class="relative">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="mt-1 w-full rounded-md border-gray-300 pr-14 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                <span
                    class="absolute inset-y-0 right-0 flex items-center justify-center w-12 cursor-pointer text-gray-400 hover:text-gray-600"
                    onclick="togglePassword('password','login-eye')"
                >
                    <i id="login-eye" class="bi bi-eye-slash text-xl"></i>
                </span>
            </div>
        </div>

        <div class="flex items-center mb-4">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
            >
            <label for="remember_me" class="ml-2 text-sm text-gray-600">
                Remember me
            </label>
        </div>

        <div class="flex justify-between items-center mb-4 text-sm">
            <a href="https://wopancoart.com/register" class="text-gray-600 hover:text-gray-900 underline">
                Register
            </a>

            <a href="https://wopancoart.com/forgot-password" class="text-gray-600 hover:text-gray-900 underline">
                Forgot password?
            </a>
        </div>

        <button
            type="submit"
            class="w-full py-2 bg-gray-800 text-white rounded-md font-semibold uppercase tracking-wide hover:bg-gray-700 transition"
        >
            Log in
        </button>
    </form>

</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        }
    }
</script>
