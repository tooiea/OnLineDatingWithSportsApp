import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { CheckCircle } from 'lucide-react';

export default function TeamRegistrationComplete() {
  return (
    <div className="bg-gradient-to-br from-blue-100 to-green-100 min-h-screen py-16 px-4 flex items-center justify-center">
      <Head title="仮登録完了" />

      <div className="bg-white/80 backdrop-blur-md border border-green-200 rounded-xl shadow-lg max-w-lg w-full px-6 py-10 text-center space-y-6">
        <div className="flex justify-center">
          <CheckCircle className="w-12 h-12 text-green-600" />
        </div>

        <h2 className="text-2xl font-bold text-green-700">仮登録が完了しました</h2>

        <p className="text-gray-700 font-semibold">
          ご登録ありがとうございます。
        </p>

        <p className="text-gray-600">
          ご入力いただいたメールアドレス宛に、<br />
          本登録用のURLをお送りしました。
        </p>

        <p className="text-gray-600">
          記載されたURLをクリックし、<br />
          <span className="font-bold text-green-700">60分以内に</span>本登録を完了してください。
        </p>

        <p className="text-sm text-gray-500">
          ※ メールが届かない場合は、迷惑メールフォルダもご確認ください。
        </p>

        <div>
          <Link
            href="/"
            className="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow transition"
          >
            トップページへ戻る
          </Link>
        </div>
      </div>
    </div>
  );
}
