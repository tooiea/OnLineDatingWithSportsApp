import React from "react";
import { Link } from '@inertiajs/react';

export default function Error403() {
  return (
    <div className="min-h-screen bg-white flex flex-col justify-center items-center px-4">
      <h1 className="text-6xl font-bold text-red-600 mb-4">403</h1>
      <p className="text-xl text-gray-800 mb-2">アクセスが拒否されました。</p>
      <p className="text-gray-600 mb-6">このページにアクセスする権限がありません。</p>
      <Link href="/" className="text-blue-600 hover:underline">ホームに戻る</Link>
      <div className="mt-10 text-sm text-gray-500">OnLine Dating With Sports</div>
    </div>
  );
}
