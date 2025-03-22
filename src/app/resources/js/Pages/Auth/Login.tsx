import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

export default function Login({
    status,
    canResetPassword,
}: {
    status?: string;
    canResetPassword: boolean;
}) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false as boolean,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('email_login.login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            {status && (
                <div className="mb-4 text-sm font-medium text-green-600">
                    {status}
                </div>
            )}

            <form onSubmit={submit}>
                <div>
                    <InputLabel htmlFor="email">メールアドレス</InputLabel>
                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        isFocused={true}
                        onChange={(e) => setData('email', e.target.value)}
                    />
                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password">パスワード</InputLabel>

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="current-password"
                        onChange={(e) => setData('password', e.target.value)}
                    />

                    <InputError message={errors.password} className="mt-2" />
                </div>

                {canResetPassword && (
                    <div className="mt-4 text-center">
                        <Link
                            href={route('password.request')}
                            className="text-sm text-gray-600 underline hover:text-gray-900"
                        >
                            パスワードをお忘れですか？
                        </Link>
                    </div>
                )}

                <div className="mt-6">
                    <PrimaryButton className="w-full justify-center" disabled={processing}>
                        ログイン
                    </PrimaryButton>
                </div>
            </form>
                <div className="mt-6 flex items-center">
                    <hr className="flex-grow border-t border-gray-300" />
                    <span className="mx-2 text-sm text-gray-500">または</span>
                    <hr className="flex-grow border-t border-gray-300" />
                </div>

                <div className="mt-4 flex justify-center gap-4">
                    <a href={route('google.login')}>
                        <img
                            src="/images/btn_google_signin_dark_normal_web@2x.png"
                            alt="google"
                            className="h-10"
                        />
                    </a>

                    <a href={route('line.login')}>
                        <img
                            src="/images/btn_login_base.png"
                            alt="line"
                            className="h-10"
                        />
                    </a>
                </div>

                {/* チーム作成への導線ボタン */}
                <div className="mt-6 text-center">
                    <span className="text-sm text-gray-600">アカウントをお持ちではありませんか？</span>
                    <Link
                        href={route('register')}
                        className="ml-2 text-sm font-medium text-indigo-600 hover:text-indigo-500"
                    >
                        新しくチームを作成
                    </Link>
                </div>
        </GuestLayout>
    );
}
