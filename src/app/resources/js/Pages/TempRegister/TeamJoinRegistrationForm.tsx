import React from 'react';
import { Head, useForm, usePage } from '@inertiajs/react';
import LabelBlock from '@/Components/LabelBlock';
import PasswordInput from '@/Components/PasswordInput';
import PasswordStrengthCheck from '@/Components/PasswordStrengthCheck';

interface Props {
  invitation_code?: string;
  old?: Record<string, any>;
  routes: {
    confirm: string;
  }
}

export default function TeamJoinRegistrationForm({
  invitation_code,
  old,
  routes,
}: Props) {
  const invitationCode = invitation_code || '';

  const {
    data,
    setData,
    post,
    processing,
    errors,
  } = useForm({
    nickname: old?.nickname || '',
    email: old?.email || '',
    password: '',
    password2: '',
    invitation_code: invitationCode,
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.confirm);
  };

  return (
    <div className="bg-gradient-to-br from-blue-100 to-green-100 min-h-screen py-10 px-4">
      <Head title="チーム登録フォーム" />

      <div className="text-center mb-10">
        <h1 className="text-3xl font-bold text-indigo-700">🏅 ユーザ登録フォーム</h1>
        <p className="mt-2 text-gray-600">仲間と出会い、目標を共有しよう！</p>
      </div>

      <form
        onSubmit={handleSubmit}
        className="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md space-y-6"
      >
        <h2 className="text-lg font-bold text-gray-700 mb-4">👤 ユーザー情報</h2>

        <div>
          <LabelBlock label="ニックネーム" required description='例：オーディー'>
            <input
              type="text"
              id="nickname"
              name="nickname"
              value={data.nickname}
              onChange={e => setData('nickname', e.target.value)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {errors.nickname && <p className="text-sm text-red-500 mt-1">{errors.nickname}</p>}
          </LabelBlock>
        </div>

        <div>
          <LabelBlock label="メールアドレス" required description='例：example@example.com'>
            <input
              type="email"
              id="email"
              name="email"
              value={data.email}
              onChange={e => setData('email', e.target.value)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {errors.email && <p className="text-sm text-red-500 mt-1">{errors.email}</p>}
          </LabelBlock>
        </div>

        <div>
          <LabelBlock label='パスワード' required description='半角英数字の小文字・大文字を最低1字含み、8文字以上で入力してください'>
            <PasswordInput
              name="password"
              value={data.password}
              onChange={e => setData('password', e.target.value)}
            />
            <PasswordStrengthCheck password={data.password} />
            {errors.password && <p className="text-sm text-red-500 mt-1">{errors.password}</p>}
          </LabelBlock>
        </div>

        <div>
          <LabelBlock label='パスワード：再入力' required description='上記のパスワードと同じ入力をしてください'>
            <PasswordInput
              name="password2"
              value={data.password2}
              onChange={e => setData('password2', e.target.value)}
            />
            <PasswordStrengthCheck password={data.password2} />
            {errors.password2 && <p className="text-sm text-red-500 mt-1">{errors.password2}</p>}
          </LabelBlock>
        </div>

        <div className="text-center">
          <button
            type="submit"
            disabled={processing}
            className="mt-6 w-full max-w-sm bg-gradient-to-r from-indigo-500 to-pink-500 hover:from-indigo-600 hover:to-pink-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-300"
          >
            🚀  ユーザ登録する
          </button>
        </div>
      </form>
    </div>
  );
}
