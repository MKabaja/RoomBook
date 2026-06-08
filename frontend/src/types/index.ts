export interface User {
  id: number;
  name: string;
  email: string;
}

export interface Room {
  id: number;
  name: string;
  capacity: number;
}

export interface Booking {
  id: number;
  room_id: number;
  room?: Room;
  starts_at: string;
  ends_at: string;
  participants_count: number;
  status: BookingStatus;
}

export type BookingStatus = 'pending' | 'confirmed' | 'cancelled';

export interface ApiError {
  message: string;
  errors?: Record<string, string[]>;
}

export interface PaginatedResponse<T> {
  data: T[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
}
