import React from 'react';
import { Head, useForm, usePage } from '@inertiajs/react';

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
    <div className="bg-gradient-to-b from-blue-50 to-white min-h-screen py-10 px-4">
      <Head title="チーム登録フォーム" />

      <div className="text-center mb-10">
        <h1 className="text-3xl font-bold text-indigo-700">🏅 ユーザ登録フォーム</h1>
        <p className="mt-2 text-gray-600">仲間と出会い、目標を共有しよう！</p>
      </div>

      <form
        onSubmit={handleSubmit}
        className="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md space-y-6"
      >
        <h2 className="text-lg font-bold text-gray-700">👤 ユーザー情報</h2>

        <input type="hidden" name="invitation_code" value={data.invitation_code} />

        <div>
          <label htmlFor="nickname" className="block font-semibold mb-1">
            ニックネーム
          </label>
          <input
            type="text"
            id="nickname"
            name="nickname"
            value={data.nickname}
            onChange={e => setData('nickname', e.target.value)}
            placeholder="例：nickname"
            className="w-full border-gray-300 rounded-md shadow-sm"
          />
          <p className="text-sm text-gray-500 mt-1">※本名での登録はご遠慮願います</p>
          {errors.nickname && <p className="text-sm text-red-500 mt-1">{errors.nickname}</p>}
        </div>

        <div>
          <label htmlFor="email" className="block font-semibold mb-1">
            メールアドレス
          </label>
          <input
            type="email"
            id="email"
            name="email"
            value={data.email}
            onChange={e => setData('email', e.target.value)}
            placeholder="例：example@example.com"
            className="w-full border-gray-300 rounded-md shadow-sm"
          />
          <p className="text-sm text-gray-500 mt-1">使用可能なメールアドレスを入力してください</p>
          {errors.email && <p className="text-sm text-red-500 mt-1">{errors.email}</p>}
        </div>

        <div>
          <label htmlFor="password" className="block font-semibold mb-1">
            パスワード
          </label>
          <input
            type="password"
            id="password"
            name="password"
            value={data.password}
            onChange={e => setData('password', e.target.value)}
            placeholder="例：passW0rd"
            className="w-full border-gray-300 rounded-md shadow-sm"
          />
          <p className="text-sm text-gray-500 mt-1">
            半角英数字の小文字・大文字を最低1字含み、8文字以上で入力してください
          </p>
          {errors.password && <p className="text-sm text-red-500 mt-1">{errors.password}</p>}
        </div>

        <div>
          <label htmlFor="password2" className="block font-semibold mb-1">
            パスワード：再入力
          </label>
          <input
            type="password"
            id="password2"
            name="password2"
            value={data.password2}
            onChange={e => setData('password2', e.target.value)}
            placeholder="例：passW0rd"
            className="w-full border-gray-300 rounded-md shadow-sm"
          />
          <p className="text-sm text-gray-500 mt-1">上記のパスワードと同じ入力をしてください</p>
          {errors.password2 && <p className="text-sm text-red-500 mt-1">{errors.password2}</p>}
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
