import dayjs from 'dayjs';
import 'dayjs/locale/ja';

dayjs.locale('ja');

/**
 * 曜日付きで日付を「YYYY年MM月DD日（ddd）～」の形式でフォーマットする
 * @param date ISO文字列 or undefined/null
 * @returns フォーマット済みの文字列 or 'ー'
 */
const FormattedFullDateTime = (date?: string | null): string => {
  return date ? `${dayjs(date).format('YYYY年MM月DD日（ddd） HH:mm')}～` : 'ー';
};

export default FormattedFullDateTime;
