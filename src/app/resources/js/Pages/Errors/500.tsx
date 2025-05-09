import React from 'react';
import { Head, usePage } from '@inertiajs/react';
import { PageProps } from '@/types';

export default function InternalServerError() {
  const { props } = usePage<PageProps & { message?: string }>();
  const errorMessage = props.message ?? '予期しないエラーが発生しました。しばらくしてからもう一度お試しください。';

  return (
    <>
      <Head title="サーバーエラー" />
      <div className="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-100 to-green-100 px-4 text-center">
        <p className="text-xl text-red-600 font-semibold mb-4">500. {errorMessage}</p>
        <div className="text-indigo-700 text-m font-bold mb-6">
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
