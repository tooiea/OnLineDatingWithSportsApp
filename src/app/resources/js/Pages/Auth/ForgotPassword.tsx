import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, useForm, usePage } from '@inertiajs/react';
import { FormEventHandler } from 'react';

export default function ForgotPassword({ status }: { status?: string }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const routes = usePage().props.guest_routes as {
        password_email: string;
        current: string;
        home: string;
        login: string;
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(routes.password_email);
    };

    return (
        <GuestLayout routes={routes}>
            <Head title="Forgot Password" />

            <div className="mb-4 text-sm text-gray-600">
            パスワードをお忘れですか？
            ご登録のメールアドレスを入力していただければ、
            新しいパスワードを設定できるリンクをメールでお送りします。
            </div>

            {status && (
                <div className="mb-4 text-sm font-medium text-green-600">
                    {status}
                </div>
            )}

            <form onSubmit={submit}>
                <TextInput
                    id="email"
                    type="email"
                    name="email"
                    value={data.email}
                    className="mt-1 block w-full"
                    isFocused={true}
                    onChange={(e) => setData('email', e.target.value)}
                />

                <InputError message={errors.email} className="mt-2" />

                <div className="mt-4 flex items-center justify-end">
                    <PrimaryButton className="ms-4" disabled={processing}>
                        Email Password Reset Link
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
