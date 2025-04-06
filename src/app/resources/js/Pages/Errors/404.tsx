import React from 'react';
import { Head } from '@inertiajs/react';

export default function NotFound() {
  return (
    <>
      <Head title="ページが見つかりません" />
      <div className="min-h-screen flex flex-col justify-center items-center bg-gray-100 text-gray-700 px-4 text-center">
        <h1 className="text-6xl font-bold text-red-600 mb-6">404</h1>
        <h2 className="text-2xl font-semibold mb-4">ページが見つかりません</h2>
        <p className="mb-8">
          お探しのページは存在しないか、移動された可能性があります。
        </p>
        <div className="text-indigo-700 text-xl font-bold mb-2">
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
