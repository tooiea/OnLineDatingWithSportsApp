import React from 'react';
import { useForm, Head, usePage } from '@inertiajs/react';
import LabelBlock from '@/Components/LabelBlock';
import PasswordInput from '@/Components/PasswordInput';
import PasswordStrengthCheck from '@/Components/PasswordStrengthCheck';

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
  old?: Partial<FormInputData>;
  routes: {
    confirm: string;
  };
}

interface FormInputData {
  [key: string]: any;
  sportAffiliationType: number | '';
  teamName: string;
  teamLogo: File | null;
  teamUrl: string;
  prefecture: number | '';
  address: string;
  nickname: string;
  email: string;
  password: string;
  password2: string;
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
    nickname: old.nickname ?? '',
    email: old.email ?? '',
    password: '',
    password2: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.confirm);
  };

  const renderError = (field: keyof typeof errors) =>
    errors[field] && <p className="text-red-500 text-sm mt-1">{errors[field]}</p>;

  return (
    <div className="bg-gradient-to-br from-blue-100 to-green-100 min-h-screen py-10 px-4">
      <Head title="チーム登録フォーム" />

      <div className="text-center mb-10">
        <h1 className="text-3xl font-bold text-indigo-700">🏅 チーム登録フォーム</h1>
        <p className="mt-2 text-gray-600">仲間と出会い、目標を共有しよう！</p>
      </div>

      <form onSubmit={handleSubmit} encType="multipart/form-data" className="max-w-2xl mx-auto space-y-8">
        <div className="bg-white rounded-xl shadow-md p-6">
          <h2 className="text-lg font-bold text-gray-700 mb-4">👤 ユーザー情報</h2>

          <LabelBlock label="ニックネーム" required description="例：オーディー">
            <input
              type="text"
              name="nickname"
              value={data.nickname}
              onChange={(e) => setData('nickname', e.target.value)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {renderError('nickname')}
          </LabelBlock>

          <LabelBlock label="メールアドレス" required description="例：example@oldws.net">
            <input
              type="email"
              name="email"
              value={data.email}
              onChange={(e) => setData('email', e.target.value)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {renderError('email')}
          </LabelBlock>

          <LabelBlock
            label="パスワード"
            required
            description="英大文字・小文字・数字・記号（@、#、$、-、_）を1文字ずつ含む8文字以上"
          >
            <PasswordInput
              value={data.password}
              onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('password', e.target.value)}
              name="password"
            />
            <PasswordStrengthCheck password={data.password} />
            {renderError('password')}
          </LabelBlock>

          <LabelBlock label="パスワード（再入力）" required description="もう一度パスワードを入力">
            <PasswordInput
              name="password2"
              value={data.password2}
              onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('password2', e.target.value)}
            />
            <PasswordStrengthCheck password={data.password2} />
            {renderError('password2')}
          </LabelBlock>
        </div>

        <div className="bg-white rounded-xl shadow-md p-6">
          <h2 className="text-lg font-bold text-gray-700 mb-4">🏆 チーム情報</h2>

          <LabelBlock label="スポーツ種別" required>
            <select
              name="sportAffiliationType"
              value={data.sportAffiliationType}
              onChange={(e) => setData('sportAffiliationType', parseInt(e.target.value) || '')}
              className="w-full border-gray-300 rounded-md shadow-sm"
            >
              <option value="">選択してください</option>
              {sports.map(sport => (
                <option key={sport.value} value={sport.value}>{sport.label}</option>
              ))}
            </select>
            {renderError('sportAffiliationType')}
          </LabelBlock>

          <LabelBlock label="チーム名" required description="例：OLDWS">
            <input
              type="text"
              name="teamName"
              value={data.teamName}
              onChange={(e) => setData('teamName', e.target.value)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {renderError('teamName')}
          </LabelBlock>

          <LabelBlock label="チームロゴ画像" required description="PNG、JPG、JPEG形式の拡張子">
            <input
              type="file"
              name="teamLogo"
              onChange={(e) => setData('teamLogo', e.target.files?.[0] || null)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {renderError('teamLogo')}
          </LabelBlock>

          <LabelBlock label="チーム紹介SNS" description="例：https://facebook.com/example">
            <input
              type="url"
              name="teamUrl"
              value={data.teamUrl}
              onChange={(e) => setData('teamUrl', e.target.value)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {renderError('teamUrl')}
          </LabelBlock>

          <LabelBlock label="活動エリア（都道府県）" required>
            <select
              name="prefecture"
              value={data.prefecture}
              onChange={(e) => setData('prefecture', parseInt(e.target.value) || '')}
              className="w-full border-gray-300 rounded-md shadow-sm"
            >
              <option value="">選択してください</option>
              {prefectures.map(pref => (
                <option key={pref.id} value={pref.id}>{pref.name}</option>
              ))}
            </select>
            {renderError('prefecture')}
          </LabelBlock>

          <LabelBlock label="市町村区" required description="例：新宿区">
            <input
              type="text"
              name="address"
              value={data.address}
              onChange={(e) => setData('address', e.target.value)}
              className="w-full border-gray-300 rounded-md shadow-sm"
            />
            {renderError('address')}
          </LabelBlock>
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
