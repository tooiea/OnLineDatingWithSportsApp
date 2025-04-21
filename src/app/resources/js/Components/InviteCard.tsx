import React from 'react';
import { Link } from '@inertiajs/react';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';
import ConsentStatusClass from './ConsentStatusClass';
import getFormattedFullDateTime from './FormattedFullDateTime';

dayjs.locale('ja');

export interface InviteData {
  id: string;
  created_at: string;
  consent_status: number;
  first_preferered_date: string;
  second_preferered_date?: string;
  third_preferered_date?: string;
  unread?: boolean;
  team: {
    id: string;
    name: string;
    image?: {
      path_base64: string;
    };
  };
  game_date?: string | null;
}

export interface InviteCardProps {
  invite: InviteData;
  inviteStatuses: Record<number, string>;
  isInviter?: boolean;
}

const renderDate = (label: string, date?: string, highlightDate?: string) => {
  const isPast = date ? dayjs(date).isBefore(dayjs()) : false;
  const isHighlight = highlightDate && date && dayjs(date).isSame(highlightDate, 'day');
  const faded = highlightDate && date && !dayjs(date).isSame(highlightDate, 'day');

  return (
    <li className="flex gap-2 items-start text-xs">
      <span>{label}</span>
      <span
        className={`flex flex-col ${isPast ? 'line-through text-gray-400' : ''
          } ${faded ? 'text-gray-400' : ''} ${isHighlight ? 'font-bold text-blue-700' : ''}`.trim()}
      >
        <span>{getFormattedFullDateTime(date)}</span>
      </span>
    </li>
  );
};

const getDeadlineLabel = (
  first?: string,
  second?: string,
  third?: string
): string | null => {
  const dates = [first, second, third]
    .filter((d): d is string => !!d)
    .map((d) => dayjs(d))
    .sort((a, b) => b.valueOf() - a.valueOf());

  if (dates.length === 0) return null;

  const deadline = dates[0].subtract(7, 'day');
  const daysLeft = deadline.diff(dayjs(), 'day');

  if (daysLeft === 7) return `⏰ 返事期限 残り7日`;
  if (daysLeft >= 4 && daysLeft <= 6) return `🕒 返事期限 残り${daysLeft}日`;
  if (daysLeft >= 1 && daysLeft <= 3) return `⚠️ 返事期限 残り${daysLeft}日`;
  if (daysLeft <= 0) return '❌ 期限切れ';
  return null;
};

const InviteCard: React.FC<InviteCardProps> = ({ invite, inviteStatuses, isInviter }) => {
  const deadlineLabel =
    invite.consent_status === 0
      ? getDeadlineLabel(
        invite.first_preferered_date,
        invite.second_preferered_date,
        invite.third_preferered_date
      )
      : null;

  const detailRoute = isInviter
    ? route('myteam.consent_game.detail', invite.id)
    : invite.consent_status === 0
      ? route('myteam.consent_game.reply.index', invite.id)
      : route('myteam.consent_game.detail', invite.id);

  return (
    <li className={`relative shadow rounded-xl w-full max-w-[420px] flex gap-4 p-4 bg-white min-h-[170px] ${invite.unread ? 'border-2 border-yellow-400 bg-yellow-50' : 'border'}`}>

      {invite.team.image && (
        <div className="relative w-16 h-16">
          <img
            src={invite.team.image.path_base64}
            alt="チーム画像"
            className="w-16 h-16 object-cover rounded"
          />
          {invite.unread && (
            <div className="absolute -top-1 bg-yellow-400 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow z-10">
              新着通知
            </div>
          )}
        </div>
      )}

      <div className="flex-1 flex flex-col justify-between">
        {/* 上部：チーム名、ステータス、日程 */}
        <div className="space-y-2">
          <div className="text-md font-bold">
            <span className="break-words">{invite.team.name}</span>
          </div>

          <div className="text-sm font-medium">
            <span className="text-gray-700 text-xs">ステータス：</span>
            <span className={`inline-block text-xs font-semibold px-1 rounded ${ConsentStatusClass(invite.consent_status)}`}>
              {inviteStatuses[invite.consent_status]}
            </span>
          </div>

          <ul className="space-y-1 min-h-[54px]">
            {renderDate('①', invite.first_preferered_date, invite.game_date ?? undefined)}
            {invite.second_preferered_date &&
              renderDate('②', invite.second_preferered_date, invite.game_date ?? undefined)}
            {invite.third_preferered_date &&
              renderDate('③', invite.third_preferered_date, invite.game_date ?? undefined)}
          </ul>
        </div>

        {/* 下部：返事期限ラベル＋ボタン */}
        <div className="flex items-center justify-between mt-3">
          {deadlineLabel ? (
            <span className="text-xs text-red-500 font-medium">
              {deadlineLabel}
            </span>
          ) : <span />}  {/* スペース確保 */}

          <Link
            href={detailRoute}
            className="text-sm text-indigo-600 hover:underline font-medium"
          >
            {isInviter || invite.consent_status !== 0 ? '詳細を見る' : '返事する'}
          </Link>
        </div>
      </div>
    </li>
  );
};

export default InviteCard;
