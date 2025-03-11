import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';
import { PageProps } from '@/types';
import dayjs from 'dayjs';

interface Invite {
  consent_games_id: number;
  consent_games_created_at: string;
  name: string;
  consent_status: number;
}

interface Props extends PageProps {
  myTeam: { name: string, id: string};
  myTeamInvites: Invite[];
  asGuestInvites: Invite[];
  session?: {
    consent?: { reply?: string; sent?: string };
  };
}

export default function TeamInvitations({ auth, myTeam, myTeamInvites, asGuestInvites, session }: Props) {
  const formatDate = (date: string) => dayjs(date).format('YYYY年MM月DD日');

  return (
    <AuthenticatedLayout>
      <Head title="チーム招待状況" />

      <div className="container mx-auto py-8 px-4">
        {/* Myチームセクション */}
        <div className="bg-white shadow-md rounded-lg p-6 mb-8">
          <h2 className="text-xl font-semibold border-b pb-2">Myチーム</h2>
          <div className="mt-4">
            <span className="font-medium">チーム名: </span>
            <Link href={route('team.detail', myTeam.id)} className="text-indigo-500 hover:underline">
              {myTeam.name}
            </Link>
            {session?.consent?.reply && (
              <div className="mt-4 p-4 bg-green-100 text-green-800 rounded">{session.consent.reply}</div>
            )}
            {session?.consent?.sent && (
              <div className="mt-4 p-4 bg-green-100 text-green-800 rounded">{session.consent.sent}</div>
            )}
          </div>
        </div>

        {/* 招待状況セクション */}
        <div className="bg-white shadow-md rounded-lg p-6 mb-8">
          <h2 className="text-xl font-semibold border-b pb-2">招待状況</h2>
          <div className="mt-4 overflow-x-auto">
            <table className="w-full table-auto">
              <thead className="bg-gray-100">
                <tr>
                  <th className="px-4 py-2 text-left">招待日</th>
                  <th className="px-4 py-2 text-left">チーム名</th>
                  <th className="px-4 py-2 text-left">進捗状況</th>
                </tr>
              </thead>
              <tbody>
                {myTeamInvites.map((invite) => (
                  <tr key={invite.consent_games_id} className="border-t">
                    <td className="px-4 py-2">{formatDate(invite.consent_games_created_at)}</td>
                    <td className="px-4 py-2">
                      <Link
                        href={route('reply.detail', invite.consent_games_id)}
                        className="text-indigo-500 hover:underline"
                      >
                        {invite.name}
                      </Link>
                    </td>
                    <td className="px-4 py-2">{invite.consent_status}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* 他チームからの招待状況セクション */}
        <div className="bg-white shadow-md rounded-lg p-6">
          <h2 className="text-xl font-semibold border-b pb-2">他チームからの招待状況</h2>
          <div className="mt-4 overflow-x-auto">
            <table className="w-full table-auto">
              <thead className="bg-gray-100">
                <tr>
                  <th className="px-4 py-2 text-left">招待日</th>
                  <th className="px-4 py-2 text-left">チーム名</th>
                  <th className="px-4 py-2 text-left">進捗状況</th>
                </tr>
              </thead>
              <tbody>
                {asGuestInvites.map((invite) => (
                  <tr key={invite.consent_games_id} className="border-t">
                    <td className="px-4 py-2">{formatDate(invite.consent_games_created_at)}</td>
                    <td className="px-4 py-2">
                      <Link
                        href={
                          invite.consent_status === 1
                            ? route('reply.index', invite.consent_games_id)
                            : route('reply.detail', invite.consent_games_id)
                        }
                        className="text-indigo-500 hover:underline"
                      >
                        {invite.name}
                      </Link>
                    </td>
                    <td className="px-4 py-2">{invite.consent_status}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}