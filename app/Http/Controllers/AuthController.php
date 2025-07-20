<?php
    namespace App\Http\Controllers ;

    use App\Http\Requests\UserAuthVerifyRequest;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\View\View;
    use Illuminate\Support\Facades\Log;


    class AuthController extends Controller
    {
        public function index() : View
        {
            return view ('auth.login');
        }

         public function verify(UserAuthVerifyRequest $request):RedirectResponse
        {
            $data = $request->validated();

            if (Auth::guard('admin')->attempt(['email' => $data['email'],'password' => $data['password'],'role' => 'admin'])){
                $request->session()->regenerate();
                return redirect()->intended('/admin/home');
            } else if (Auth::guard('client')->attempt(['email' => $data['email'],'password' => $data['password'],'role' => 'client'])){
                $request->session()->regenerate();
                return redirect()->intended('/client/home');
            } else if (Auth::guard('supervisor')->attempt(['email' => $data['email'],'password' => $data['password'],'role' => 'supervisor'])) {
                $request->session()->regenerate();
                $user = Auth::guard('supervisor')->user();
            // Jika supervisor harus ganti password
            if ($user->must_change_password) {
                return redirect()->route('supervisor.password.change');
            }
                return redirect()->intended('/supervisor/home');
            }else {
                return redirect(route('login'))->with('msg', 'Email atau Password salah');
            }
        }


        public function logout(): RedirectResponse
        {
            if(Auth::guard('admin') -> check()){
                Auth::guard('admin')->logout();
            }else if(Auth::guard('client') -> check()){
                Auth::guard('client')->logout();
            }else if(Auth::guard('supervisor') -> check()){
                Auth::guard('supervisor')->logout();
            }
            return redirect(route('login'));
        }
        }
