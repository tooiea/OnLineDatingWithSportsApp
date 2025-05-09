import React from 'react';
import { Head } from '@inertiajs/react';

export default function NotFound() {
  return (
    <>
      <Head title="ページが見つかりません" />
      <div className="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-100 to-green-100 px-4 text-center">
        <p className="text-xl font-semibold mb-4">404. ページが見つかりません</p>
        <p className="mb-8">
          お探しのページは存在しないか、移動された可能性があります。
        </p>
        <div className="text-indigo-700 text-m font-bold mb-2">
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
