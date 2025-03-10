import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import { PageProps } from '@/types';

interface Team {
    id: number;
    name: string;
    prefecture_code: number;
    address: string;
    team_logo?: string;
    image_extension?: string;
    code?: { code?: string };
}

interface Prefecture {
    value: number;
    label: string;
}

export default function SearchTeam({ auth, teams, filters, prefectures }: PageProps<{ teams: any, filters: any, prefectures: Prefecture[] }>) {
    const [prefecture, setPrefecture] = useState<string>(filters.prefecture || '');
    const [address, setAddress] = useState<string>(filters.address || '');

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        router.get(route('team.list'), { prefecture, address });
    };

    return (
        <AuthenticatedLayout>
            <Head title="招待チームを検索" />

            <div className="max-w-5xl mx-auto px-6 py-10">
                <div className="bg-white shadow-md rounded-xl p-8">
                    <h2 className="text-xl font-semibold mb-4 border-b pb-2">招待チームを検索</h2>
                    <form onSubmit={submit} className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label className="block mb-1 text-sm font-medium">都道府県</label>
                            <select
                                value={prefecture}
                                onChange={(e) => setPrefecture(e.target.value)}
                                className="block w-full border-gray-300 rounded-md shadow-sm"
                            >
                                <option value="">選択してください</option>
                                {prefectures.map((pref) => (
                                    <option key={pref.value} value={pref.value}>{pref.label}</option>
                                ))}
                            </select>
                            <span className="text-sm text-gray-500">検索したいチームの都道府県を選択してください。</span>
                        </div>

                        <div>
                            <label className="block mb-1 text-sm font-medium">住所（市町村区）</label>
                            <input
                                type="text"
                                value={address}
                                onChange={(e) => setAddress(e.target.value)}
                                className="block w-full border-gray-300 rounded-md shadow-sm"
                                placeholder="例：宮崎市"
                            />
                            <span className="text-sm text-gray-500">市町村区を入力してください。</span>
                        </div>

                        <button type="submit" className="col-span-full bg-indigo-500 hover:bg-indigo-600 text-white rounded-md py-2 font-semibold">
                            検索する
                        </button>
                    </form>
                </div>

                <div className="mt-8">
                    {teams.data.length === 0 ? (
                        <div className="text-center text-gray-600">
                            該当するチームが登録されていません。
                        </div>
                    ) : (
                        <div className="overflow-x-auto">
                            <table className="hidden md:table w-full table-auto shadow-sm rounded-xl overflow-hidden">
                                <thead className="bg-gray-100 text-left">
                                    <tr>
                                        <th className="px-4 py-2">No</th>
                                        <th className="px-4 py-2">チーム名</th>
                                        <th className="px-4 py-2">活動拠点</th>
                                        <th className="px-4 py-2">ロゴ</th>
                                        <th className="px-4 py-2">招待</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {teams.data.map((team: Team, index: number) => (
                                        <tr key={team.id} className="border-t">
                                            <td className="px-4 py-2">{index + 1}</td>
                                            <td className="px-4 py-2 font-medium">{team.name}</td>
                                            <td className="px-4 py-2">{team.address}</td>
                                            <td className="px-4 py-2">
                                                {team.team_logo && (
                                                    <img src={team.team_logo} alt="logo" className="w-10 h-10 object-cover rounded-md" />
                                                )}
                                            </td>
                                            <td className="px-4 py-2">
                                                <Link href={route('team.invite_game', team.code?.code)} className="text-indigo-500 hover:underline">
                                                    招待する
                                                </Link>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>

                            <div className="md:hidden space-y-4">
                                {teams.data.map((team: Team) => (
                                    <div key={team.id} className="bg-white shadow rounded-lg p-4">
                                        <div className="font-semibold">{team.name}</div>
                                        <div className="text-sm text-gray-600">{team.address}</div>
                                        <div className="mt-2 flex justify-between items-center">
                                            {team.team_logo && <img src={team.team_logo} alt="logo" className="w-10 h-10 rounded-md" />}
                                            <Link href={route('team.invite_game', team.code?.code)} className="text-indigo-500 text-sm font-medium hover:underline">
                                                招待する
                                            </Link>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}
                </div>

                {teams.links && (
                    <div className="mt-4 flex justify-center flex-wrap gap-2">
                        {teams.links.map((link: any, index: number) => (
                            <Link
                                key={index}
                                href={link.url || '#'}
                                className={`px-3 py-1 border rounded ${link.active ? 'bg-indigo-500 text-white' : 'bg-white text-gray-600'} hover:bg-indigo-400 hover:text-white transition-colors duration-200 text-sm`}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ))}
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}