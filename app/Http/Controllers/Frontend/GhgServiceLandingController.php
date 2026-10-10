<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGhgConsultationRequest;
use App\Jobs\SyncGhgConsultationToSheet;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class GhgServiceLandingController extends Controller
{
    public function index(): View
    {
        return view('frontend.landing.ghg-service.index', [
            'recaptchaSiteKey' => config('ghg_landing.recaptcha_secret_key')
                ? config('ghg_landing.recaptcha_site_key') : null,
        ]);
    }

    public function store(StoreGhgConsultationRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();
        $isCallback = $data['consultation_type'] === 'callback';
        $message = $isCallback ? 'Khách hàng yêu cầu gọi lại tư vấn kiểm kê khí nhà kính.'
            : 'Khách hàng đăng ký tư vấn và nhận báo giá dịch vụ kiểm kê khí nhà kính.';

        if (filled($data['company_name'] ?? null)) {
            $message .= "\nDoanh nghiệp: ".$data['company_name'];
        }

        if (filled($data['message'] ?? null)) {
            $message .= "\nNội dung: ".$data['message'];
        }

        $contact = Contact::query()->create([
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'topic' => $isCallback ? 'Yêu cầu gọi lại - Kiểm kê khí nhà kính' : 'Tư vấn dịch vụ kiểm kê khí nhà kính',
            'message' => $message,
            'source' => route('ghg-service.index'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'sheets_sync_key' => (string) Str::uuid(),
            'sheets_payload' => [
                'company_name' => $data['company_name'] ?? '',
                'message' => $data['message'] ?? '',
                'consultation_type' => $isCallback ? 'Yêu cầu gọi lại' : 'Đăng ký tư vấn',
            ],
        ]);

        SyncGhgConsultationToSheet::dispatch($contact->id)->afterResponse();

        $success = 'Đã gửi yêu cầu thành công! Chuyên viên Bảo Châu sẽ liên hệ tư vấn cho bạn trong thời gian sớm nhất.';

        if ($request->expectsJson()) {
            return response()->json(['message' => $success], 201);
        }

        return redirect()->to(route('ghg-service.index').'#form-register-login-features')
            ->with('consultation_success', $success)
            ->with('consultation_form_id', $data['form_id']);
    }
}
