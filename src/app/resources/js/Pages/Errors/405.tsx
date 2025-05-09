import React from 'react';
import { Link, Head } from '@inertiajs/react';

export default function Error405() {
  return (
    <>
      <Head title="アクセス方法が正しくありません" />
      <div className="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 to-green-100 text-center px-4">
        <p className="text-xl font-semibold text-gray-800 mb-2">405. ページを表示できません</p>
        <p className="text-gray-700 mb-6">
          正しくアクセスできませんでした。<br />
          トップページからやり直してください。
        </p>
        <Link
          href="/"
          className="text-white bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded shadow"
        >
          トップページへ戻る
        </Link>
      </div>
    </>
  );
}
