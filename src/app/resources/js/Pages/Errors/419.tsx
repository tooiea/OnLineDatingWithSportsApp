import React from 'react';
import { Link, Head } from '@inertiajs/react';

export default function Error419() {
  return (
    <>
      <Head title="セッションの有効期限切れ" />
      <div className="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 to-green-100 text-center px-4">
        <p className="text-xl font-semibold text-gray-800 mb-2">419. セッションの有効期限が切れました。</p>
        <p className="text-gray-600 mb-6">ページの有効期限が切れている可能性があります。もう一度お試しください。</p>
        <Link href="/" className="text-white bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded shadow">
          ホームに戻る
        </Link>
      </div>
    </>
  );
}
