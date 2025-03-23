import React from 'react';
import { Head, Link } from '@inertiajs/react';

export default function TeamRegistrationComplete() {
  return (
    <div className="container py-10 px-4 mx-auto max-w-2xl">
      <Head title="仮登録完了" />

      <div className="bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-md">
        <div className="bg-green-500 text-white text-center py-4 rounded-t-lg">
          <h2 className="text-xl font-bold">仮登録完了です</h2>
        </div>

        <div className="p-6 text-center space-y-4">
          <h4 className="text-lg font-semibold">仮登録いただきありがとうございました。</h4>
          <p>入力されたメールアドレスへ本登録用のURLを送信しております。</p>
          <p>
            メールに記載のURLより、ユーザ本登録が完了となりますので
            <span className="font-bold">1時間以内</span>に本登録をお願い致します。
          </p>

          <div className="mt-6">
            <Link href="/" className="text-blue-600 hover:underline">
              トップページへ戻る
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
}
