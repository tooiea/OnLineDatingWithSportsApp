import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import LabelBlock from '@/Components/LabelBlock';

interface Props {
  nickname: string;
  email: string;
  routes: {
    complete: string;
    back: string;
  };
}

export default function TeamJoinRegistrationConfirm({
    nickname,
    email,
    routes,
}: Props) {
  const { post, processing } = useForm({});

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.complete);
  };

  const handleBack = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.back);
  };

  return (
    <div className="bg-gradient-to-br from-blue-100 to-green-100 min-h-screen py-10 px-4">
      <Head title="登録内容の確認" />

      <div className="container mx-auto max-w-xl">
        <h1 className="text-2xl font-bold text-center text-indigo-700 mb-8">登録内容の確認</h1>

        <form onSubmit={handleSubmit} className="space-y-8">
          <div className="bg-white shadow-md rounded-lg p-6">
            <h2 className="text-lg font-semibold border-b pb-2 mb-4">👤 ユーザー情報</h2>
            <div className="space-y-3">
              <div>
                <LabelBlock label='ニックネーム'>{nickname}</LabelBlock>
              </div>
              <div>
                <LabelBlock label='メールアドレス'>{email}</LabelBlock>
              </div>
              <div>
                <LabelBlock label='パスワード'>********</LabelBlock>
              </div>
            </div>
          </div>

          <div className="flex justify-between">
            <button
              type="button"
              onClick={handleBack}
              className="inline-block bg-gray-300 hover:bg-gray-400 text-black py-2 px-6 rounded"
            >
              戻る
            </button>

            <button
              type="submit"
              disabled={processing}
              className="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded font-semibold"
            >
              登録する
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
