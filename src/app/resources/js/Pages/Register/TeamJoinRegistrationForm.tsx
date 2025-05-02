import React from 'react';
import { Head, useForm, router } from '@inertiajs/react';

interface FormInput {
  teamUrl: string;
  [key: string]: string;
}

interface Props {
  routes: {
    confirm: string;
    select: string;
  };
}

export default function TeamJoinRegistrationForm({ routes }: Props) {
  const { data, setData, post, processing, errors } = useForm<FormInput>({
    teamUrl: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.confirm);
  };

  const handleselect = () => {
    router.visit(routes.select);
  };

  return (
    <div className="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-green-100 overflow-hidden px-4 py-12">
      <Head title="チーム参加フォーム" />

      {/* ボールの装飾 */}
      <img src="/images/ball-soccer.png" alt="Soccer Ball" className="absolute top-4 left-4 w-20 md:w-20 lg:w-24" />
      <img src="/images/ball-baseball.png" alt="Baseball" className="absolute top-6 right-4 w-16 md:w-16 lg:w-20" />
      <img src="/images/ball-volleyball.png" alt="Volleyball" className="absolute bottom-4 left-4 w-24 md:w-20 lg:w-24" />
      <img src="/images/ball-basketball.png" alt="Basketball" className="absolute bottom-6 right-4 w-20 md:w-20 lg:w-24" />

      {/* メインコンテンツ */}
      <div className="bg-white rounded-2xl shadow-lg p-8 max-w-lg w-full text-center space-y-6 z-10">
        <h1 className="text-2xl font-bold text-indigo-700">
          🏆 チームへ参加しましょう！
        </h1>

        <form onSubmit={handleSubmit} className="space-y-6">
          <div className="text-left">
            <label htmlFor="teamUrl" className="block text-sm font-medium text-gray-700">
              招待URL
            </label>
            <input
              type="url"
              name="teamUrl"
              id="teamUrl"
              value={data.teamUrl}
              onChange={e => setData('teamUrl', e.target.value)}
              placeholder="例)https://oldws.sakura.ne.jp/temp_register/team/join/1234567890xxxx"
              className={`mt-1 w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 ${
                errors.teamUrl || errors.invitation_code ? 'border-red-500' : ''
              }`}
            />
            {errors.teamUrl && (
              <p className="text-sm text-red-500 mt-1">{errors.teamUrl}</p>
            )}
            {errors.invitation_code && (
              <p className="text-sm text-red-500 mt-1">{errors.invitation_code}</p>
            )}
            <small className="text-gray-500">招待用のURLを貼り付けてください</small>
          </div>

          <button
            type="submit"
            disabled={processing}
            className="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-full hover:bg-indigo-700 shadow-md transition duration-300"
          >
            確認する
          </button>

          <button
            type="button"
            onClick={handleselect}
            className="w-full border border-gray-400 text-gray-700 font-bold py-2 px-4 rounded-full hover:bg-gray-100 shadow-sm transition duration-300"
          >
            ← 登録方法の選択に戻る
          </button>
        </form>
      </div>
    </div>
  );
}
