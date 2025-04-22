import React from 'react';
import { useForm, Head, usePage } from '@inertiajs/react';

interface Prefecture {
  id: number;
  name: string;
}

interface SportAffiliationType {
  value: number;
  label: string;
}

interface Props {
  prefectures: Prefecture[];
  sports: SportAffiliationType[];
}

interface FormInputData {
  [key: string]: string | number | File | null | '';
  sportAffiliationType: number | '';
  teamName: string;
  teamLogo: File | null;
  teamUrl: string;
  prefecture: number | '';
  address: string;
}

export default function TeamRegistrationForm({ prefectures, sports }: Props) {
  const { props } = usePage();
  const old = props?.old as Partial<FormInputData> ?? {};
  const { data, setData, post, processing, errors } = useForm<FormInputData>({
    sportAffiliationType: old.sportAffiliationType ?? '',
    teamName: old.teamName ?? '',
    teamLogo: null,
    teamUrl: old.teamUrl ?? '',
    prefecture: old.prefecture ?? '',
    address: old.address ?? '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('register.team.confirm'));
  };

  const renderError = (field: keyof typeof errors) =>
    errors[field] && <p className="text-red-500 text-sm mt-1">{errors[field]}</p>;

  return (
    <div className="bg-gradient-to-b from-blue-50 to-white min-h-screen py-10 px-4">
      <Head title="チーム登録フォーム" />

      <div className="text-center mb-10">
        <h1 className="text-3xl font-bold text-indigo-700">🏅 チーム登録フォーム</h1>
        <p className="mt-2 text-gray-600">チームの基本情報を入力してください</p>
      </div>

      <form
        onSubmit={handleSubmit}
        encType="multipart/form-data"
        className="max-w-2xl mx-auto space-y-8"
      >
        <div className="bg-white rounded-xl shadow-md p-6">
          <h2 className="text-lg font-bold text-gray-700 mb-4">🏆 チーム情報</h2>

          <label className="block mb-2 font-semibold">スポーツ種別</label>
          <select
            name="sportAffiliationType"
            value={data.sportAffiliationType}
            onChange={e => setData('sportAffiliationType', parseInt(e.target.value) || '')}
            className="w-full border-gray-300 rounded-md shadow-sm"
          >
            <option value="">選択してください</option>
            {sports.map(sport => (
              <option key={sport.value} value={sport.value}>
                {sport.label}
              </option>
            ))}
          </select>
          {renderError('sportAffiliationType')}

          <label className="block mt-4 mb-2 font-semibold">チーム名</label>
          <input
            type="text"
            name="teamName"
            placeholder="例：チーム名"
            value={data.teamName}
            onChange={e => setData('teamName', e.target.value)}
            className="w-full border-gray-300 rounded-md shadow-sm"
          />
          {renderError('teamName')}

          <label className="block mt-4 mb-2 font-semibold">チームロゴ画像</label>
          <input
            type="file"
            name="teamLogo"
            onChange={e => setData('teamLogo', e.target.files?.[0] || null)}
            className="w-full border-gray-300 rounded-md shadow-sm"
          />
          {renderError('teamLogo')}

          <label className="block mt-4 mb-2 font-semibold">チーム紹介SNS</label>
          <input
            type="url"
            name="teamUrl"
            placeholder="例：https://facebook.com/example/"
            value={data.teamUrl}
            onChange={e => setData('teamUrl', e.target.value)}
            className="w-full border-gray-300 rounded-md shadow-sm"
          />
          {renderError('teamUrl')}

          <label className="block mt-4 mb-2 font-semibold">活動エリア（都道府県）</label>
          <select
            name="prefecture"
            value={data.prefecture}
            onChange={e => setData('prefecture', parseInt(e.target.value) || '')}
            className="w-full border-gray-300 rounded-md shadow-sm"
          >
            <option value="">選択してください</option>
            {prefectures.map(pref => (
              <option key={pref.id} value={pref.id}>
                {pref.name}
              </option>
            ))}
          </select>
          {renderError('prefecture')}

          <label className="block mt-4 mb-2 font-semibold">市町村区</label>
          <input
            type="text"
            name="address"
            placeholder="例：宮崎市"
            value={data.address}
            onChange={e => setData('address', e.target.value)}
            className="w-full border-gray-300 rounded-md shadow-sm"
          />
          {renderError('address')}
        </div>

        <div className="text-center">
          <button
            type="submit"
            disabled={processing}
            className="mt-8 w-full max-w-sm bg-gradient-to-r from-indigo-500 to-pink-500 hover:from-indigo-600 hover:to-pink-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-300"
          >
            🚀 チームを作成する
          </button>
        </div>
      </form>
    </div>
  );
}
