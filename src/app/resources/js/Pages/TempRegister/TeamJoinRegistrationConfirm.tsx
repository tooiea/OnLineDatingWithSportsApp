import React from 'react';
import { Head, useForm } from '@inertiajs/react';

interface Props {
  nickname: string;
  email: string;
  invitation_code?: string;
}

export default function TeamJoinRegistrationConfirm(props: Props) {
  const invitationCode = props.invitation_code || '';
  const { post, processing } = useForm({});

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('temp_register.team.join.complete', { invitation_code: invitationCode }));
  };

  const handleBack = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('temp_register.team.join.back', { invitation_code: invitationCode }));
  };

  return (
    <div className="bg-gradient-to-b from-blue-50 to-white min-h-screen py-10 px-4">
      <Head title="登録内容の確認" />

      <div className="container mx-auto max-w-xl">
        <h1 className="text-2xl font-bold text-center text-indigo-700 mb-8">登録内容の確認</h1>

        <form onSubmit={handleSubmit} className="space-y-8">
          <div className="bg-white shadow-md rounded-lg p-6">
            <h2 className="text-lg font-semibold border-b pb-2 mb-4">👤 ユーザー情報</h2>
            <div className="space-y-3">
              <div>
                <label className="font-semibold">ニックネーム</label>
                <div className="text-gray-800">{props.nickname}</div>
              </div>
              <div>
                <label className="font-semibold">メールアドレス</label>
                <div className="text-gray-800">{props.email}</div>
              </div>
              <div>
                <label className="font-semibold">パスワード</label>
                <div className="text-gray-400">********</div>
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
