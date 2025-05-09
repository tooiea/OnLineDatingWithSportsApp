import React from 'react';
import { useForm, Head, usePage, router } from '@inertiajs/react';
import LabelBlock from '@/Components/LabelBlock';

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
  routes: {
    confirm: string;
    select: string;
  };
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

export default function TeamRegistrationForm({ prefectures, sports, routes }: Props) {
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
    post(routes.confirm);
  };

  const handleselect = () => {
    router.visit(routes.select);
  };

  const renderError = (field: keyof typeof errors) =>
    errors[field] && <p className="text-red-500 text-sm mt-1">{errors[field]}</p>;

  return (
    <div className="bg-gradient-to-br from-blue-100 to-green-100 min-h-screen py-10 px-4">
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

          <LabelBlock label='スポーツ種別' required>
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
          </LabelBlock>

          <LabelBlock label='チーム名' required description='例：チーム名'>
            <input
              type="text"
              name="teamName"
              value={data.teamName}
              onChange={e => setData('teamName', e.target.value)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {renderError('teamName')}
          </LabelBlock>

          <LabelBlock label='チームロゴ画像' required description='PNG, JPG, PNG、JPG、JPEG形式の拡張子'>
            <input
              type="file"
              name="teamLogo"
              onChange={e => setData('teamLogo', e.target.files?.[0] || null)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {renderError('teamLogo')}
          </LabelBlock>

          <LabelBlock label='チーム紹介SNS' description='例：https://facebook.com/example/'>
            <input
              type="url"
              name="teamUrl"
              value={data.teamUrl}
              onChange={e => setData('teamUrl', e.target.value)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {renderError('teamUrl')}
          </LabelBlock>

          <LabelBlock label='活動エリア（都道府県）' required>
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
          </LabelBlock>

          <LabelBlock label='市町村区' required description='例：新宿区'>
            <input
              type="text"
              name="address"
              value={data.address}
              onChange={e => setData('address', e.target.value)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {renderError('address')}
          </LabelBlock>

          <button
            type="submit"
            disabled={processing}
            className="mt-8 w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-full hover:bg-indigo-700 shadow-md transition duration-300"
          >
            確認する
          </button>

          <button
            type="button"
            onClick={handleselect}
            className="mt-8 w-full border border-gray-400 text-gray-700 font-bold py-2 px-4 rounded-full hover:bg-gray-100 shadow-sm transition duration-300"
          >
            ← 登録方法の選択に戻る
          </button>

        </div>
      </form>
    </div>
  );
}
