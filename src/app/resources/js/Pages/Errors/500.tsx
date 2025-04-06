import React from 'react';
import { Head, usePage } from '@inertiajs/react';
import { PageProps } from '@/types';

export default function InternalServerError() {
  const { props } = usePage<PageProps & { message?: string }>();
  const errorMessage = props.message ?? '予期しないエラーが発生しました。しばらくしてからもう一度お試しください。';

  return (
    <>
      <Head title="サーバーエラー" />
      <div className="min-h-screen flex flex-col justify-center items-center bg-gray-100 text-gray-700 px-4 text-center">
        <h1 className="text-6xl font-bold text-red-600 mb-6">500</h1>
        <h2 className="text-2xl font-semibold mb-4">サーバーエラーが発生しました</h2>
        <p className="mb-8">{errorMessage}</p>
        <div className="text-indigo-700 text-xl font-bold mb-6">
          OnLine Dating With Sports
        </div>
        <a
          href="/"
          className="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition"
        >
          トップページに戻る
        </a>
      </div>
    </>
  );
}
